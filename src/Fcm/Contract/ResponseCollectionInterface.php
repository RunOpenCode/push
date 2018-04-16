<?php

namespace RunOpenCode\Push\Fcm\Contract;

use RunOpenCode\Push\Fcm\Contract\ResponseInterface;

interface ResponseCollectionInterface extends \IteratorAggregate, \JsonSerializable
{
    /**
     * Add response to collection.
     *
     * @param \RunOpenCode\Push\Fcm\Contract\ResponseInterface $response
     *
     * @return ResponseCollectionInterface $this
     */
    public function add(ResponseInterface $response): ResponseCollectionInterface;
}
