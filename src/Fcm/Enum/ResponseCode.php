<?php

namespace RunOpenCode\Push\Fcm\Enum;

final class ResponseCode
{
    /**
     * @var int Success
     */
    const OK = 200;

    /**
     * @var int Invalid json
     */
    const BAD_REQUEST = 400;

    /**
     * @var int Authentication error
     */
    const AUTHENTICATION_ERROR = 401;

    /**
     * @var int Internal server error
     */
    const INTERNAL_SERVER_ERROR = 500;

    private function __construct() { /* noop */ }
}