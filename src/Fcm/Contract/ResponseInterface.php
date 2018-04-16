<?php

namespace RunOpenCode\Push\Fcm\Contract;

interface ResponseInterface extends \JsonSerializable
{
    /**
     * Get response ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get FCM message
     *
     * @return \RunOpenCode\Push\Fcm\Contract\MessageInterface
     */
    public function getMessage(): MessageInterface;

    /**
     * Get canonical ID (new registration ID, if provided)
     *
     * @return string|null
     */
    public function getCanonicalId(): ?string;

    /**
     * Get response code
     *
     * @return int
     */
    public function getResponseCode(): int;

    /**
     * Get response action
     *
     * @return string
     */
    public function getResponseAction(): string;

    /**
     * Get error reson
     *
     * @return null|string
     */
    public function getErrorReason(): ?string;

    /**
     * Get response timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime;

    /**
     * Get timestamp when message can be resent again
     *
     * @return \DateTime|null
     */
    public function getRetryAfter(): ?\DateTime;
}
