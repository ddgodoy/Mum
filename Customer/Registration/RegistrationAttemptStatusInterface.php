<?php

namespace Customer\Registration;

interface RegistrationAttemptStatusInterface
{
    /**
     * Get the status id
     *
     * @return integer
     */
    public function getId();

    /**
     * Get the next status
     *
     * @return RegistrationAttemptStatusInterface|null
     */
    public function next();
}