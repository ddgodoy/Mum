<?php

namespace AppBundle\Controller;

use AppBundle\Form\CustomerContactsType;
use AppBundle\ResponseObjects\CustomerContacts;
use AppBundle\ResponseObjects\CustomerContactsUpdateStats;
use FOS\RestBundle\Controller\Annotations as FOSRestBundleAnnotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ContactsController
 *
 * @package AppBundle\Controller
 *
 * @FOSRestBundleAnnotations\View()
 */
class ContactsController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Update customer contacts
     *
     * @param Request $request
     * @return CustomerContactsUpdateStats|\Symfony\Component\Form\FormErrorIterator
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @FOSRestBundleAnnotations\Route("/customers/me/contacts")
     *
     * @ApiDoc(
     *  section="Contacts",
     *  description="Update customer contacts",
     *  input="AppBundle\Form\CustomerContactsType",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function postAction(Request $request)
    {
        $customer = $this->getUser();

        $customerContactsForm = $this->createForm(new CustomerContactsType());

        $customerContactsForm->handleRequest($request);

        if ($customerContactsForm->isValid()) {
            $contacts = $customerContactsForm->get('contacts')->getData();

            $contactsHandler = $this->get('mum.customer.contacts');
            $response = $contactsHandler->update($customer, $contacts);
            return new CustomerContactsUpdateStats(
                $response['created'],
                $response['deleted'],
                $response['unmodified'],
                $response['nonPresent']);
        }

        return $customerContactsForm->getErrors();
    }

    /**
     * Response with the customer contacts that has {customer} for id
     *
     * @return CustomerContacts
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @FOSRestBundleAnnotations\Route("/customers/me/contacts")
     *
     * @ApiDoc(
     *  section="Contacts",
     *  description="Get a customer contacts",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function getAction()
    {
        $customer = $this->getUser();
        return new CustomerContacts($customer->getContacts()->getValues());
    }
}
