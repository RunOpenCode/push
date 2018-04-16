<?php

namespace RunOpenCode\Push\Fcm\Enum;

final class ResponseAction
{
    /**
     * Token is invalid, remove it from your system.
     */
    const REMOVE = 'remove';

    /**
     * Token value should be updated to new value.
     */
    const UPDATE = 'update';

    /**
     * Everything is fine, do nothing.
     */
    const NOTHING = 'nothing';

    /**
     * You have to try to send message again to this device.
     */
    const RETRY = 'retry';

    /**
     * You have to wait some time and try again to connect with a server.
     */
    const RECONNECT = 'reconnect';

    /**
     * There has been an critical error which requires intervention.
     */
    const ERROR = 'error';

    private function __construct() { /* noop */ }
}