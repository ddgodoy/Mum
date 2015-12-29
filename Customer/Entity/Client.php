<?php

namespace Customer\Entity;

/**
 * Class Client
 * @package Customer\Entity
 */
class Client implements OAuthClientInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * Client constructor.
     * @param null $id
     * @param null $name
     */
    public function __construct($id = null, $name = null)
    {
        if ($id) {
            $this->id = $id;
        } else {
            $this->id = uniqid();
        }
        if ($name) {
            $this->name = $name;
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}