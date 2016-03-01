<?php

namespace AppBundle\ResponseObjects;

/**
 * Class CustomerContactsUpdateStats
 *
 * @package AppBundle\ResponseObjects
 */
class CustomerContactsUpdateStats
{
    /**
     * @var array
     */
    public $created;

    /**
     * @var array
     */
    public $deleted;

    /**
     * @var array
     */
    public $unmodified;

    /**
     * @var array
     */
    public $nonPresent;

    /**
     * CustomerContactsUpdateStats constructor.
     *
     * @param $created
     * @param $deleted
     * @param $unmodified
     * @param $nonPresent
     */
    public function __construct(Array $created, Array $deleted, Array $unmodified, Array $nonPresent)
    {
        $this->created = $created;
        $this->deleted = $deleted;
        $this->unmodified = $unmodified;
        $this->nonPresent = $nonPresent;
    }
}