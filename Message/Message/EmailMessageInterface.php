<?php

namespace Message\Message;

/**
 * Interface EmailMessageInterface
 *
 * @package Message\Message
 */
interface EmailMessageInterface
{
    /**
     * Set Email Message about
     *
     * @param string $about
     */
    public function setAbout($about);

    /**
     * Get Email Message about
     *
     * @return string
     */
    public function getAbout();

    /**
     * Set Email Message from email
     *
     * @param string $fromAddress
     */
    public function setFromAddress($fromAddress);

    /**
     * Get Email Message from email
     *
     * @return string
     */
    public function getFromAddress();
}