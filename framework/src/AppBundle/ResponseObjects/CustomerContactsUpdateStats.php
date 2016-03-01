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
     * @var integer
     */
    public $created;

    /**
     * @var integer
     */
    public $deleted;

    /**
     * @var integer
     */
    public $unmodified;

    /**
     * @var integer
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
    public function __construct($created, $deleted, $unmodified, $nonPresent)
    {
        $this->created = $created;
        $this->deleted = $deleted;
        $this->unmodified = $unmodified;
        $this->nonPresent = $nonPresent;
    }
}