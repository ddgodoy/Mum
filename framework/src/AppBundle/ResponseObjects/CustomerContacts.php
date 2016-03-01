<?php

namespace AppBundle\ResponseObjects;

/**
 * Class CustomerContacts
 *
 * @package AppBundle\ResponseObjects
 */
class CustomerContacts
{
    /**
     * @var array
     */
    public $contacts = [];

    /**
     * Customer constructor.
     *
     * @param array $contacts
     */
    public function __construct(Array $contacts)
    {
        foreach ($contacts as $contact) {
            $this->contacts[] = [
                'id' => $contact->getId(),
                'username' => $contact->getUsername()
            ];
        }
    }
}