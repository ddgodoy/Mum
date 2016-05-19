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
}