<?php

namespace RunOpenCode\Push\Fcm\Enum;

final class ErrorReason
{
    /**
     * Registration token is not provided. Fix your code.
     */
    const MISSING_REGISTRATION = 'MissingRegistration';

    /**
     * Registration token is corrupted. Fix your code.
     */
    const INVALID_REGISTRATION = 'InvalidRegistration';

    /**
     * Some of the registration tokens are corrupted when
     * sending push notification to multiple devices.
     *
     * Remove invalid registration token.
     */
    const INVALID_PARAMETERS = 'InvalidParameters';

    /**
     * Remove registration token.
     */
    const NOT_REGISTERED = 'NotRegistered';

    /**
     * That token is not for configured application. Fix your code.
     */
    const INVALID_PACKAGE_NAME = 'InvalidPackageName';

    /**
     * Server is unavailable, try again later.
     */
    const UNAVAILABLE = 'Unavailable';

    /**
     * Server is unavailable, try again later.
     */
    const INTERNAL_SERVER_ERROR = 'InternalServerError';

    /**
     * Wrong sender id. Fix your settings.
     */
    const MISMATCH_SENDER_ID = 'MismatchSenderId';

    /**
     * Message is too big. Fix your code
     */
    const MESSAGE_TOO_BIG = 'MessageTooBig';

    /**
     * Data key is wrong. Fix your code.
     */
    const INVALID_DATA_KEY = 'InvalidDataKey';

    /**
     * Ttl must be between 0 and 2,419,200. Fix your code.
     */
    const INVALID_TTL = 'InvalidTtl';

    /**
     * The rate of messages to a particular device is too high.
     * Reduce the number of messages sent to this device and do not immediately retry sending to this device.
     *
     * Add throttling to this device.
     */
    const DEVICE_MESSAGE_RATE_EXCEEDED = 'DeviceMessageRateExceeded';

    /**
     * The rate of messages to subscribers to a particular topic is too high.
     * Reduce the number of messages sent for this topic, and do not immediately retry sending.
     *
     * Add throttling to this topic.
     */
    const TOPICS_MESSAGE_RATE_EXCEEDED = 'TopicsMessageRateExceeded';

    /**
     * FCM DOES NOT DEFINES THIS CONSTANT!
     *
     * Invalid JSON provided with message.
     */
    const INVALID_JSON = 'InvalidJson';

    /**
     * FCM DOES NOT DEFINES THIS CONSTANT!
     *
     * Could not authenticate with server.
     */
    const AUTHENTICATION_ERROR = 'AuthenticationError';

    private function __construct() { /* noop */ }
}
