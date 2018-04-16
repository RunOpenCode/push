<?php

namespace RunOpenCode\Push\Fcm\Model;

use RunOpenCode\Push\Fcm\Contract\MessageInterface;
use RunOpenCode\Push\Fcm\Contract\ResponseInterface;
use RunOpenCode\Push\Fcm\Enum\ErrorReason;
use RunOpenCode\Push\Fcm\Enum\ResponseAction;
use RunOpenCode\Push\Fcm\Enum\ResponseCode;
use RunOpenCode\Push\Fcm\Exception\RuntimeException;

final class Response implements ResponseInterface
{
    /**
     * @var null
     */
    private $id;

    /**
     * @var \RunOpenCode\Push\Fcm\Contract\MessageInterface
     */
    private $message;

    /**
     * @var string|null
     */
    private $canonicalId;

    /**
     * @var int
     */
    private $responseCode;

    /**
     * @var string|null
     */
    private $errorReason;

    /**
     * @var string
     */
    private $responseAction;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var \DateTime|null
     */
    private $retryAfter;

    public function __construct(
        string $id,
        MessageInterface $message,
        int $responseCode,
        ?string $canonicalId = null,
        ?string $errorReason = null,
        ?string $responseAction = null,
        \DateTime $timestamp = null,
        \DateTime $retryAfter = null
    )
    {
        $this->setId($id);
        $this->setMessage($message);
        $this->setCanonicalId($canonicalId);
        $this->setResponseCode($responseCode);
        $this->setErrorReason($errorReason);
        $this->setResponseAction($responseAction);
        $this->setTimestamp($timestamp);
        $this->setRetryAfter($retryAfter);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage(): MessageInterface
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getCanonicalId(): string
    {
        return $this->canonicalId;
    }

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    /**
     * @return string
     */
    public function getResponseAction(): string
    {
        return $this->responseAction;
    }

    /**
     * @return null|string
     */
    public function getErrorReason(): ?string
    {
        return $this->errorReason;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return \DateTime|null
     */
    public function getRetryAfter(): ?\DateTime
    {
        return $this->retryAfter;
    }

    /**
     * {@inheritdoc}
     */
    public function fromArray(array $data)
    {
        if (isset($data['timestamp'])) {
            $data['timestamp'] = \DateTime::createFromFormat(\DateTime::ATOM, $data['timestamp']);
        }

        if (isset($data['retryAfter'])) {
            $data['retryAfter'] = \DateTime::createFromFormat(\DateTime::ATOM, $data['retryAfter']);
        }

        if (isset($data['message']) && is_array($data['message'])) {
            /**
             * @var Message $message
             */
            $message = (new \ReflectionClass(Message::class))->newInstanceWithoutConstructor();
            $message->fromArray($data['message']);
            $data['message'] = $message;
        }

        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'id'             => $this->id,
            'message'        => $this->message,
            'canonicalId'    => $this->canonicalId,
            'responseCode'   => $this->responseCode,
            'errorReason'    => $this->errorReason,
            'responseAction' => $this->responseAction,
            'timestamp'      => $this->timestamp->format(\DateTime::ATOM),
            'retryAfter'     => null !== $this->retryAfter ? $this->retryAfter->format(\DateTime::ATOM) : null,
        ];
    }

    /**
     * @param mixed $id
     *
     * @return Response
     */
    private function setId($id): Response
    {
        $this->id = (string) $id;

        return $this;
    }

    /**
     * @param MessageInterface $message
     *
     * @return Response
     */
    private function setMessage(MessageInterface $message): Response
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param null|string $canonicalId
     *
     * @return Response
     */
    private function setCanonicalId(?string $canonicalId): Response
    {
        $this->canonicalId = $canonicalId;

        return $this;
    }

    /**
     * @param int $responseCode
     *
     * @return Response
     */
    private function setResponseCode(int $responseCode): Response
    {
        $codes = (new \ReflectionClass(ResponseCode::class))->getConstants();

        if (!in_array($responseCode, $codes, true)) {
            throw new RuntimeException(sprintf('Unknown response code "%s".', $responseCode));
        }

        $this->responseCode = $responseCode;

        return $this;
    }

    /**
     * @param null|string $errorReason
     * @return Response
     */
    private function setErrorReason(?string $errorReason)
    {
        $codes = (new \ReflectionClass(ErrorReason::class))->getConstants();

        if (null !== $errorReason && !in_array($errorReason, $codes, true)) {
            throw new RuntimeException(sprintf('Unknown error reason "%s".', $errorReason));
        }

        $this->errorReason = $errorReason;

        return $this;
    }

    /**
     * @param string $responseAction
     *
     * @return Response
     */
    private function setResponseAction(string $responseAction)
    {
        if (null === $responseAction) {

            $responseAction = ResponseAction::NOTHING;

            if (ResponseCode::OK !== $this->responseCode || null !== $this->errorReason) {

                switch ($this->errorReason) {
                    case ErrorReason::NOT_REGISTERED:
                    case ErrorReason::INVALID_REGISTRATION:
                    case ErrorReason::INVALID_PARAMETERS:
                        $responseAction = ResponseAction::REMOVE;
                        break;
                    case ErrorReason::UNAVAILABLE:
                    case ErrorReason::INTERNAL_SERVER_ERROR:
                    case ErrorReason::DEVICE_MESSAGE_RATE_EXCEEDED:
                    case ErrorReason::TOPICS_MESSAGE_RATE_EXCEEDED:
                        $responseAction = ResponseAction::RETRY;
                        break;
                    default:
                        $responseAction = ResponseAction::ERROR;

                        if (ErrorReason::INVALID_REGISTRATION === $this->errorReason) {
                            $responseAction = ResponseAction::REMOVE;
                        }
                        break;
                }
            }

            if (ResponseCode::OK === $this->responseCode && null !== $this->canonicalId) {
                $responseAction = ResponseAction::UPDATE;
            }
        }

        $codes = (new \ReflectionClass(ResponseAction::class))->getConstants();

        if (!in_array($responseAction, $codes, true)) {
            throw new RuntimeException(sprintf('Unknown response action "%s".', $responseAction));
        }

        $this->responseAction = $responseAction;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return Response
     */
    private function setTimestamp(?\DateTime $timestamp)
    {
        $this->timestamp = (null !== $timestamp) ? $timestamp : new \DateTime('now');

        return $this;
    }

    /**
     * @param \DateTime|null $retryAfter
     * @return Response
     */
    private function setRetryAfter(?\DateTime $retryAfter)
    {
        $this->retryAfter = $retryAfter;

        return $this;
    }

}