<?php

namespace Customer\OAuth;

/**
 * Interface OAuthClientInterface
 * @package Customer\Entity
 */
interface OAuthClientInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();
}