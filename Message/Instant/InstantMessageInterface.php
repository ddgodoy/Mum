<?php

namespace Message\Instant;

use Message\Message\MessageDependantInterface;

/**
 * Interface InstantMessageInterface
 *
 * @package Message\Instant
 */
interface InstantMessageInterface extends MessageDependantInterface
{
    /**
     * Gets the instant chat room id
     *
     * @return RoomInterface
     */
    public function getRoom();

    /**
     * Gets received
     *
     * @return bool
     */
    public function getReceived();

    /**
     * Set received
     *
     * @param bool $received
     */
    public function setReceived($received);
}