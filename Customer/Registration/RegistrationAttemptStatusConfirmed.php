<?php

namespace Customer\Registration;

class RegistrationAttemptStatusConfirmed implements RegistrationAttemptStatusInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * RegistrationAttemptStatusConfirmed constructor.
     */
    public function __construct()
    {
        $this->id = 3;
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
        return null;
    }
}