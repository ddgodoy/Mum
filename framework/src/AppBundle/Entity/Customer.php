<?php

namespace AppBundle\Entity;

use Customer\Customer\Customer as CustomerBase;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Customer ORM Entity
 *
 * @package AppBundle\Entity
 *
 * @Hateoas\Relation("self", href = @Hateoas\Route("get_customers", parameters = { "customer" = "expr(object.getId())" }))
 * @Hateoas\Relation("customers", href = @Hateoas\Route("cget_customers"))))
 */
class Customer extends CustomerBase
{
    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \DateTime
     */
    protected $updated;

    /**
     * @var \DateTime
     */
    protected $deletedAt;

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
