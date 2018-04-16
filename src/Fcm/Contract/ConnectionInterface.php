<?php

namespace RunOpenCode\Push\Fcm\Contract;

interface ConnectionInterface
{
    /**
     * Opens a connection with FCM server.
     *
     * @return void
     *
     * @throws \RunOpenCode\Push\Fcm\Exception\RuntimeException
     * @throws \RunOpenCode\Push\Fcm\Exception\ConnectionException
     */
    public function open(): void;

    /**
     * Closes a connection with APNS server.
     *
     * @return void
     *
     * @throws \RunOpenCode\Push\Fcm\Exception\RuntimeException
     * @throws \RunOpenCode\Push\Fcm\Exception\ConnectionException
     */
    public function close(): void;

    /**
     * Sends a message to a APNS server.
     *
     * @param MessageInterface $message Message to send
     *
     * @return ResponseCollectionInterface Server responses
     *
     * @throws \RunOpenCode\Push\Fcm\Exception\RuntimeException
     * @throws \RunOpenCode\Push\Fcm\Exception\ConnectionException
     * @throws \RunOpenCode\Push\Fcm\Exception\TransportException
     */
    public function send(MessageInterface $message): ResponseCollectionInterface;
}
