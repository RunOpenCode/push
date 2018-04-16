<?php

namespace Fcm\Connection;

use RunOpenCode\Push\Fcm\Contract\ConnectionInterface;
use RunOpenCode\Push\Fcm\Contract\MessageInterface;
use RunOpenCode\Push\Fcm\Contract\ResponseCollectionInterface;

final class Connection implements ConnectionInterface
{
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function open(): void
    {
        $this->connection->open();
    }

    /**
     * {@inheritdoc}
     */
    public function close(): void
    {
        $this->connection->close();
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message): ResponseCollectionInterface
    {
        return $this->connection->send($message);
    }
}
