<?php

namespace Customer\Registration;

class RegistrationAttemptStatusSent implements RegistrationAttemptStatusInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * RegistrationAttemptStatusSent constructor.
     */
    public function __construct()
    {
        $this->id = 2;
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
        return new RegistrationAttemptStatusConfirmed();
    }
}