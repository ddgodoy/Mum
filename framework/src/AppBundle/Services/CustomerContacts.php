<?php

namespace AppBundle\Services;

use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CustomerContacts
 *
 * @package AppBundle\Services
 */
class CustomerContacts
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * CustomerRegistration constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Update customer contacts
     *
     * @param CustomerInterface $customer
     * @param array $contacts
     * @return mixed
     */
    public function update(CustomerInterface $customer, Array $contacts)
    {
        $created = 0;
        $deleted = 0;
        $unmodified = 0;

        // remove himself if it exist in its contacts
        $index = array_search($customer->getUsername(), $contacts);
        if ($index !== false) {
            unset($contacts[$index]);
        }

        // retrieve all contacts for this customer
        $dbContacts = $customer->getContacts();

        // remove non present on new contacts from db and unmodified from new contacts leaving only new contacts on it
        foreach ($dbContacts as $contact) {
            if (in_array($contact->getUsername(), $contacts)) {
                $unmodified++;
                $index = array_search($contact->getUsername(), $contacts);
                if ($index !== false) {
                    unset($contacts[$index]);
                }
            } else {
                $customer->removeContact($contact);
                $deleted++;
            }
        }

        // loop through new contacts and save them
        $dbContacts = $this->em->getRepository('AppBundle:Customer')->getByIds($contacts);
        $nonPresent = count($contacts) - count($dbContacts);
        foreach ($dbContacts as $contact) {
            $customer->addContact($contact);
            $created++;
        }
        $this->em->flush();

        return [
            'created' => $created,
            'deleted' => $deleted,
            'unmodified' => $unmodified,
            'nonPresent' => $nonPresent
        ];
    }
}