<?php

namespace Message\Message;

/**
 * Class ScheduledMessageStatusCreated
 *
 * @package Message\Message
 */
class ScheduledMessageStatusCreated implements ScheduledMessageStatusInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * RegistrationAttemptStatusCreated constructor.
     */
    public function __construct()
    {
        $this->id = 1;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        return new ScheduledMessageStatusProcessing();
    }
}