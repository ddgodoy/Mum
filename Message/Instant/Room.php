<?php

namespace Message\Instant;

/**
 * Class Room
 *
 * @package Message\Instant
 */
class Room implements RoomInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * InstantMessage constructor.
     *
     * @param string|null $id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
        if (!$this->id) {
            $this->id = uniqid();
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
}