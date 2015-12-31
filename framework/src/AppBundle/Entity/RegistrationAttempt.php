<?php

namespace AppBundle\Entity;

use Customer\Registration\RegistrationAttempt as BaseRegistrationAttempt;
use Customer\Registration\RegistrationAttemptStatusConfirmed;
use Customer\Registration\RegistrationAttemptStatusCreated;
use Customer\Registration\RegistrationAttemptStatusSent;

/**
 * Class RegistrationAttempt
 *
 * @package AppBundle\Entity
 */
class RegistrationAttempt extends BaseRegistrationAttempt
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
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

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
    public function getUpdated()
    {
        return $this->updated;
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
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * PrePersist and PreUpdate convert the status object to integer
     */
    public function convertStatusToInteger()
    {
        $this->status = $this->status->getId();
    }

    /**
     * PostPersist, PostUpdate and PostLoad convert the status from integer
     */
    public function convertStatusFromInteger()
    {
        switch ($this->status) {
            case 1: {
                $this->status = new RegistrationAttemptStatusCreated();
                break;
            }
            case 2: {
                $this->status = new RegistrationAttemptStatusSent();
                break;
            }
            case 3: {
                $this->status = new RegistrationAttemptStatusConfirmed();
                break;
            }
        }
    }
}