<?php

namespace Customer\Registration;

/**
 * Class RegistrationAttemptStatusCreated
 *
 * @package Customer\Registration
 */
class RegistrationAttemptStatusCreated implements RegistrationAttemptStatusInterface
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
        return new RegistrationAttemptStatusSent();
    }
}