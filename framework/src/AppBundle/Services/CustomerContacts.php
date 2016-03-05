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

        return [
            "deleted" => $deleted,
            "deletedContactInfo" => $deletedContactInfo,
            "unmodified" => $unmodified,
            "unmodifiedContactInfo" => $unmodifiedContactInfo,
            "contacts" => $contacts
        ];
    }

    /**
     * Format phone numbers to prepare for db match
     *
     * @param array $contacts
     * @param CustomerInterface $customer
     * @return array
     */
    private function sanitizeContacts(Array $contacts, CustomerInterface $customer)
    {
        foreach ($contacts as &$contact) {
            // if the phone number don't starts with (+) or (00) elsewhere is international
            if (substr($contact, 0, 1) !== '+' && substr($contact, 0, 2) !== '00') {
                // if ti has (0) as first digit remove it
                if (substr($contact, 0, 1) === '0') {
                    $contact = substr($contact, 1);
                }

                // add customer international code to it
                $contact = sprintf("%s%s", $customer->getCountryCode(), $contact);
            } else {
                if (substr($contact, 0, 1) === '+') {
                    $contact = substr($contact, 1);
                }

                if (substr($contact, 0, 2) === '00') {
                    $contact = substr($contact, 2);
                }
            }

            $chars = [' ', '-', '+', '(', ')'];
            foreach ($chars as $char) {
                $contact = str_replace($char, '', $contact);
            }
        }

        return $contacts;
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
        $contacts = $this->sanitizeContacts($contacts, $customer);

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