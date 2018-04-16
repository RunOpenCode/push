<?php

namespace Fcm\Connection\Adapter;

use RunOpenCode\Push\Fcm\Contract\ConnectionInterface;
use RunOpenCode\Push\Fcm\Contract\MessageInterface;
use RunOpenCode\Push\Fcm\Contract\ResponseCollectionInterface;
use RunOpenCode\Push\Fcm\Exception\TransportException;
use RunOpenCode\Push\Fcm\Model\ResponseCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GuzzleHttp\Client as GuzzleClient;

final class Http implements ConnectionInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;

    public function __construct(array $options = [])
    {
        $this->options = $this->configureOptions($options);
    }

    public function open(): void
    {
        if ($this->client) {
            return;
        }

        if (!defined('CURL_HTTP_VERSION_2_0') && $this->options['debug']) {
            trigger_error('This environment does not have CURL with HTTP/2 version supported. Sending oush notifications to FCM server will be deployed at lower pace. Consider upgrading environment.', E_USER_WARNING);
        }

        $defaults = [
            'headers' => [
                'Content-Type'  => 'application/json',
                'Authorization' => sprintf('Basic  %s', $this->options['api_key']),
            ],
            'version' => defined('CURL_HTTP_VERSION_2_0') ? 2.0 : 1.1,
            'verify'  => $this->options['verify_peer'],
        ];


        $this->client = new GuzzleClient($defaults);
    }

    public function close(): void
    {
        $this->client = null;
    }

    public function send(MessageInterface $message): ResponseCollectionInterface
    {
        $payload = $this->getPayload($message);

        try {
            $response = $this->client->request('POST', $this->options['api_endpoint'], [
                'body' => json_encode($payload),
            ]);
        } catch (\Exception $e) {
            throw new TransportException(sprintf('Unable to deliver message "%s" to FCM server via "%s" connection.', $message->getId(), get_class($this)));
        }

        switch ($response->getStatusCode()) {
            case 200:
                $data = json_decode($response->getBody()->getContents());

                return ResponseCollection::fromSuccess200($message, $data);
            case 400:
                return ResponseCollection::fromError400($message);
            case 401:
                return ResponseCollection::fromError401($message);
            case 403:
                return ResponseCollection::fromError403($message);
            default:
                $retryAfter = $response->getHeader('retry-after');

                if (count($retryAfter) > 0) {
                    $retryAfter = is_numeric($retryAfter) ? new \DateTime(sprintf('+%s sec', $retryAfter)) : \DateTime::createFromFormat(\DateTime::RFC1123, $retryAfter);
                }

                return (500 === $response->getStatusCode()) ? ResponseCollection::fromError500($message, $retryAfter) : ResponseCollection::fromError5xx($message, $retryAfter);
                break;
        }
    }


    private function getPayload(MessageInterface $message)
    {
        $payload = [
            'to'                      => count($message->getRegistrationIds()) === 1 ? $message->getRegistrationIds()[0] : null,
            'registration_ids'        => count($message->getRegistrationIds()) > 1 ? $message->getRegistrationIds() : null,
            'priority'                => $message->getPriority(),
            'notification'            => [
                'title'          => $message->getTitle(),
                'body'           => $message->getBody(),
                'icon'           => $message->getIcon(),
                'sound'          => $message->getSound(),
                'vibrate'        => $message->getVibrate(),
                'badge'          => $message->getBadge(),
                'click_action'   => $message->getClickAction(),
                'body_loc_key'   => $message->getBodyLocKey(),
                'body_loc_args'  => $message->getBodyLocArgs(),
                'title_loc_key'  => $message->getTitleLocKey(),
                'title_loc_args' => $message->getTitleLocArgs(),
                'tag'            => $message->getTag(),
                'color'          => $message->getColor(),
            ],
            'data'                    => $message->getData(),
            'condition'               => $message->getCondition(),
            'collapse_key'            => $message->getCollapseKey(),
            'time_to_live'            => $message->getTimeToLive(),
            'restricted_package_name' => $message->getRestrictedPackageName(),
            'dry_run'                 => $message->getDryRun(),
            'content_available'       => $message->getContentAvailable(),
            'android_channel_id'      => $message->getAndroidChannelId(),
        ];

        $cleanUp = function(array $subject) use (&$cleanUp) {

            foreach ($subject as $key => $item) {

                if (is_array($item)) {
                    $subject[$key] = $cleanUp($item);
                }

                if ((is_array($item) && 0 === count($item)) || null === $item) {
                    unset($subject[$key]);
                }
            }

            return $subject;
        };

        return $cleanUp($payload);
    }

    private function configureOptions(array $options): array
    {
        $resolver = new OptionsResolver();

        $resolver->setDefault('api_endpoint', 'https://fcm.googleapis.com/fcm/send');
        $resolver->setAllowedTypes('api_endpoint', 'string');
        $resolver->setAllowedValues('api_endpoint', function($value) {
            return filter_var($value, FILTER_VALIDATE_URL) !== false;
        });

        $resolver->setRequired('api_key');
        $resolver->setAllowedTypes('api_key', 'string');

        $resolver->setDefault('port', 443);
        $resolver->setAllowedTypes('port', 'int');
        $resolver->setAllowedValues('port', [443, 2197]);

        $resolver->setDefault('verify_peer', false);
        $resolver->setAllowedTypes('verify_peer', ['bool', 'string']);
        $resolver->setAllowedValues('verify_peer', function($value) {
            if (is_bool($value)) {
                return true;
            }

            return is_file($value) && is_readable($value);
        });

        $resolver->resolve($options);
    }
}
