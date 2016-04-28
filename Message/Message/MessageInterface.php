<?php

namespace Message\Message;

use Customer\Customer\CustomerInterface;

/**
 * Interface MessageInterface
 *
 * @package Message\Message
 */
interface MessageInterface
{
    /**
     * Get the Message id
     *
     * @return string
     */
    public function getId();

    /**
     * Set Message Customer sender
     *
     * @param CustomerInterface $customer
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Get the customer sender
     *
     * @return CustomerInterface
     */
    public function getCustomer();

    /**
     * Set the Message body
     *
     * @param string $body
     */
    public function setBody($body);

    /**
     * Get the Message body
     *
     * @return string
     */
    public function getBody();
    
    /**
     * Set the Message attachment
     *
     * @param string $attachment
     */
    public function setAttachment($attachment);

    /**
     * Get the Message attachment
     *
     * @return string
     */
    public function getAttachment();
}