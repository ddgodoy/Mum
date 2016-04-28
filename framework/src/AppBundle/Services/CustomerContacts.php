<?php

namespace AppBundle\Services;

use Customer\Customer\CustomerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * Remove non present on new contacts from db and unmodified from new contacts leaving only new contacts on it
     *
     * @param Collection $dbContacts
     * @param array $contacts
     * @param CustomerInterface $customer
     * @return array
     */
    private function removeContacts(Collection $dbContacts, Array $contacts, CustomerInterface $customer)
    {
        $deleted = [];
        $deletedContactInfo = [];
        $unmodified = [];
        $unmodifiedContactInfo = [];

        foreach ($dbContacts as $contact) {
            if (in_array($contact->getUsername(), $contacts)) {
                $unmodified[] = $contact->getUsername();
                $unmodifiedContactInfo[] = [
                    'id' => $contact->getId(),
                    'username' => $contact->getUsername()
                ];
                echo $contact->getUsername().PHP_EOL;
                print_r($contacts).PHP_EOL;
                echo array_search($contact->getUsername(), $contacts).PHP_EOL;
                while ($index = array_search($contact->getUsername(), $contacts)) {
                    unset($contacts[$index]);
                }
            } else {
                $customer->removeContact($contact);
                $deleted[] = $contact->getUsername();
                $deletedContactInfo[] = [
                    'id' => $contact->getId(),
                    'username' => $contact->getUsername()
                ];
            }
        }
        die("here");
        return [
            "deleted" => $deleted,
            "deletedContactInfo" => $deletedContactInfo,
            "unmodified" => $unmodified,
            "unmodifiedContactInfo" => $unmodifiedContactInfo,
            "contacts" => $contacts
        ];
    }

    /**
     * Save new contacts
     *
     * @param array $contacts
     * @param CustomerInterface $customer
     * @return array
     */
    private function createContacts(Array $contacts, CustomerInterface $customer)
    {
        $dbContacts = $this->em->getRepository('AppBundle:Customer')->getListByUsername($contacts);

        $created = [];
        $createdContactInfo = [];

        foreach ($dbContacts as $contact) {
            $customer->addContact($contact);
            $created[] = $contact->getUsername();
            $createdContactInfo[] = [
                'id' => $contact->getId(),
                'username' => $contact->getUsername()
            ];
        }

        $this->em->flush();

        return [
            "created" => $created,
            "createdContactInfo" => $createdContactInfo,
            "contacts" => $contacts
        ];
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
        // remove himself if it exist in its contacts
        $index = array_search($customer->getUsername(), $contacts);
        if ($index !== false) {
            unset($contacts[$index]);
        }

        // retrieve all contacts for this customer
        $dbContacts = $customer->getContacts();

        $response = $this->removeContacts($dbContacts, $contacts, $customer);
        $contacts = $response["contacts"];
        $deleted = $response["deleted"];
        $deletedContactInfo = $response["deletedContactInfo"];
        $unmodified = $response["unmodified"];
        $unmodifiedContactInfo = $response["unmodifiedContactInfo"];

        $response = $this->createContacts($contacts, $customer);
        $created = $response["created"];
        $createdContactInfo = $response["createdContactInfo"];
        $contacts = $response["contacts"];

        // compute non presents
        $merge = array_merge($created, $deleted, $unmodified);
        $diff = array_diff($contacts, $merge);
        $nonPresent = array_values($diff);

        return [
            'created' => $createdContactInfo,
            'deleted' => $deletedContactInfo,
            'unmodified' => $unmodifiedContactInfo,
            'nonPresent' => $nonPresent
        ];
    }
}