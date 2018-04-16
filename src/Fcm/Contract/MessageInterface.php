<?php

namespace RunOpenCode\Push\Fcm\Contract;

interface MessageInterface extends \JsonSerializable
{
    /**
     * Get message id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get message recipients
     *
     * @return string[]
     */
    public function getRegistrationIds(): array;

    /**
     * Get message title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Get message body
     *
     * @return string|null
     */
    public function getBody(): ?string;

    /**
     * Get android channel id
     *
     * @return null|string
     */
    public function getAndroidChannelId(): ?string;

    /**
     * Get message custom data
     *
     * @return array|null
     */
    public function getData(): ?array;

    /**
     * Should message vibrate
     *
     * @return boolean|null
     */
    public function getVibrate(): ?bool;

    /**
     * Get message sound
     *
     * @return string|null
     */
    public function getSound(): ?string;

    /**
     * Get message icon
     *
     * @return string|null
     */
    public function getIcon(): ?string;

    /**
     * Get message tag
     *
     * @return string|null
     */
    public function getTag(): ?string;

    /**
     * Get message color
     *
     * @return string|null
     */
    public function getColor(): ?string;

    /**
     * Get message collapse key
     *
     * @return string|null
     */
    public function getCollapseKey(): ?string;

    /**
     * Get message time to live in seconds
     *
     * @return int|null
     */
    public function getTimeToLive(): ?int;

    /**
     * Get message restricted package name
     *
     * @return string|null
     */
    public function getRestrictedPackageName(): ?string;

    /**
     * Is message sent to FCM without delivery to device
     *
     * @return boolean|null
     */
    public function getDryRun(): ?bool;

    /**
     * Get message priority
     *
     * @see Priority
     *
     * @return string|null
     */
    public function getPriority(): ?string;

    /**
     * Get broadcast condition
     *
     * @return string|null
     */
    public function getCondition(): ?string;

    /**
     * APNS support - should awake device
     *
     * @return boolean|null
     */
    public function getContentAvailable(): ?bool;

    /**
     * APNS support - get badge count
     *
     * @return int|null
     */
    public function getBadge(): ?int;

    /**
     * APNS support - get click action
     *
     * @return null|string
     */
    public function getClickAction(): ?string;

    /**
     * APNS support - get body-loc-key
     *
     * @return null|string
     */
    public function getBodyLocKey(): ?string;

    /**
     * APNS support - get body-loc-args
     *
     * @return array|null
     */
    public function getBodyLocArgs(): ?array ;

    /**
     * APNS support - get title-loc-key
     *
     * @return null|string
     */
    public function getTitleLocKey(): ?string;

    /**
     * APNS support - get title-loc-args
     *
     * @return array|null
     */
    public function getTitleLocArgs(): ?array ;

    /**
     * Get message send count
     *
     * @return int
     */
    public function getSendCount(): ?int;
}
