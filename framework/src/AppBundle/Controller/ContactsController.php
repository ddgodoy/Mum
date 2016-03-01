<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerContactsType;
use AppBundle\ResponseObjects\CustomerContactsUpdateStats;
use AppBundle\ResponseObjects\CustomerRegistration;
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
     * @param Customer $customer
     * @param Request $request
     * @return CustomerRegistration|\Symfony\Component\Form\FormErrorIterator
     * @throws HttpException
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @FOSRestBundleAnnotations\Route("/customers/{customer}/contacts")
     *
     * @ApiDoc(
     *  section="Contacts",
     *  description="Update customer contacts",
     *  input="AppBundle\Form\CustomerContactsType",
     *  requirements={
     *      {
     *          "name"="customer",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="customer id"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         500="Returned on not found customer"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function postAction(Customer $customer = null, Request $request)
    {
        if (!$customer) {
            throw new HttpException(500, 'Customer not found');
        }

        $customerContactsForm = $this->createForm(new CustomerContactsType());

        $customerContactsForm->handleRequest($request);

        if ($customerContactsForm->isValid()) {
            $contacts = json_decode($customerContactsForm->get('contacts')->getData());

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
}
