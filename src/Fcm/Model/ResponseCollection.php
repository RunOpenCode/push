<?php

namespace RunOpenCode\Push\Fcm\Model;

use RunOpenCode\Push\Fcm\Contract\MessageInterface;
use RunOpenCode\Push\Fcm\Contract\ResponseCollectionInterface;
use RunOpenCode\Push\Fcm\Contract\ResponseInterface;
use RunOpenCode\Push\Fcm\Enum\ErrorReason;
use RunOpenCode\Push\Fcm\Enum\ResponseAction;
use RunOpenCode\Push\Fcm\Enum\ResponseCode;
use RunOpenCode\Push\Fcm\Exception\RuntimeException;

final class ResponseCollection implements ResponseCollectionInterface, \ArrayAccess
{
    /**
     * @var ResponseInterface[]
     */
    private $responses;

    public function __construct(array $responses = [])
    {
        $this->responses = $responses;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->responses);

    }

    /**
     * {@inheritdoc}
     */
    public function add(ResponseInterface $response): ResponseCollectionInterface
    {
        $this->responses[] = $response;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return $this->responses;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->responses);
    }

    /**
     * {@inheritdoc}
     *
     * @return ResponseInterface
     */
    public function offsetGet($offset)
    {
        return $this->responses[$offset];
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function offsetSet($offset, $value)
    {
        if (null !== $offset) {
            throw new \InvalidArgumentException(sprintf('It is not allowed to set element offset in collection "%s".', get_class($this)));
        }

        $this->responses[] = $value;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \BadMethodCallException
     */
    public function offsetUnset($offset)
    {
        throw new \BadMethodCallException(sprintf('It is not allowed to unset element in collection "%s".', get_class($this)));
    }

    public static function fromSuccess200(MessageInterface $message, array $payload): ResponseCollection
    {
        if (!isset($payload['multicast_id'], $payload['success'], $payload['failure'], $payload['canonical_ids'])) {
            throw new RuntimeException('Response does not contains expected fields.');
        }

        $results = new static();

        if (isset($payload['results']) && count($payload['results'])) {

            $count = count($payload['results']);

            for ($i = 0; $i < $count; $i++) {

                $data           = $payload['results'][$i];
                $id             = $payload['multicast_id'];
                $canonicalId    = isset($data['registration_id']) ? $data['registration_id'] : null;
                $responseCode   = ResponseCode::OK;
                $errorReason    = isset($data['error']) ? $data['error'] : null;
                $registrationId = $message->getRegistrationIds()[$i];
                $message        = self::getMessageForRegistrationId($message, $registrationId);

                $results[] = new Response($id, $message, $responseCode, $canonicalId, $errorReason);
            }

        }

        foreach ($message->getRegistrationIds() as $registrationId) {

            $id           = $payload['multicast_id'];
            $message      = self::getMessageForRegistrationId($message, $registrationId);
            $responseCode = ResponseCode::OK;

            $results[] = new Response($id, $message, $responseCode, $canonicalId, $errorReason);
        }

        return $results;
    }

    public static function fromError400(MessageInterface $message): ResponseCollection
    {
        $results = new ResponseCollection();

        foreach ($message->getRegistrationIds() as $registrationId) {

            $id           = $message->getId();
            $message      = self::getMessageForRegistrationId($message, $registrationId);
            $responseCode = ResponseCode::BAD_REQUEST;
            $errorReason  = ErrorReason::INVALID_JSON;

            $results[] = new Response($id, $message, $responseCode, null, $errorReason);
        }

        return $results;
    }

    public static function fromError401(MessageInterface $message): ResponseCollection
    {
        $results = new ResponseCollection();

        foreach ($message->getRegistrationIds() as $registrationId) {

            $id           = $message->getId();
            $message      = self::getMessageForRegistrationId($message, $registrationId);
            $responseCode = ResponseCode::AUTHENTICATION_ERROR;
            $errorReason  = ErrorReason::AUTHENTICATION_ERROR;

            $results[] = new Response($id, $message, $responseCode, null, $errorReason);
        }

        return $results;
    }

    public static function fromError403(MessageInterface $message): ResponseCollection
    {
        return self::fromError401($message);
    }

    public static function fromError500(MessageInterface $message, \DateTime $retryAfter = null): ResponseCollection
    {
        $results = new ResponseCollection();

        foreach ($message->getRegistrationIds() as $registrationId) {

            $id             = $message->getId();
            $message        = self::getMessageForRegistrationId($message, $registrationId);
            $responseCode   = ResponseCode::INTERNAL_SERVER_ERROR;
            $errorReason    = ErrorReason::INTERNAL_SERVER_ERROR;
            $responseAction = ResponseAction::RETRY;
            $retryAfter     = null !== $retryAfter ? clone $retryAfter : null;

            $results[] = new Response($id, $message, $responseCode, null, $errorReason, $responseAction, null, $retryAfter);
        }

        return $results;
    }

    public static function fromError5xx(MessageInterface $message, \DateTime $retryAfter = null): ResponseCollection
    {
        $results = new ResponseCollection();

        foreach ($message->getRegistrationIds() as $registrationId) {

            $id             = $message->getId();
            $message        = self::getMessageForRegistrationId($message, $registrationId);
            $responseCode   = ResponseCode::INTERNAL_SERVER_ERROR;
            $errorReason    = ErrorReason::UNAVAILABLE;
            $responseAction = ResponseAction::RETRY;
            $retryAfter     = null !== $retryAfter ? clone $retryAfter : null;

            $results[] = new Response($id, $message, $responseCode, null, $errorReason, $responseAction, null, $retryAfter);
        }

        return $results;
    }

    private static function getMessageForRegistrationId(MessageInterface $message, string $registrationId): MessageInterface
    {
        if (1 === count($message->getRegistrationIds())) {
            return clone  $message;
        }

        return new Message(); // TODO
    }
}