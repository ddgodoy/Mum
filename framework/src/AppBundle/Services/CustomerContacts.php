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
        $created = [];
        $deleted = [];
        $unmodified = [];

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
                $unmodified[] = [
                    'id' => $contact->getId(),
                    'username' => $contact->getUsername()
                ];
                $index = array_search($contact->getUsername(), $contacts);
                if ($index !== false) {
                    unset($contacts[$index]);
                }
            } else {
                $customer->removeContact($contact);
                $deleted[] = [
                    'id' => $contact->getId(),
                    'username' => $contact->getUsername()
                ];
            }
        }

        // loop through new contacts and save them
        $dbContacts = $this->em->getRepository('AppBundle:Customer')->getByIds($contacts);
        foreach ($dbContacts as $contact) {
            $customer->addContact($contact);
            $created[] = [
                'id' => $contact->getId(),
                'username' => $contact->getUsername()
            ];
        }
        $this->em->flush();

        // compute non presents
        $nonPresent = array_values(array_diff($contacts, array_merge($created, $deleted, $unmodified)));

        return [
            'created' => $created,
            'deleted' => $deleted,
            'unmodified' => $unmodified,
            'nonPresent' => $nonPresent
        ];
    }
}