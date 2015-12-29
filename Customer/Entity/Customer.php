<?php

namespace Customer\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class Customer
 * @package Customer\Entity
 */
class Customer extends BaseUser
{

    /**
     * @var string
     */
    protected $id;

    /**
     * Customer constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
        if (!$this->id) {
            $this->id = uniqid();
        }
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}