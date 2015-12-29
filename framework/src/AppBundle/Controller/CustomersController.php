<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;
use FOS\RestBundle\Controller\Annotations as FOSRestBundleAnnotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

/**
 * @FOSRestBundleAnnotations\View()
 */
class CustomersController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Response with all customers registered on the database
     *
     * @ApiDoc(
     *  section="Customer",
     *  resource=true,
     *  description="Get all customers",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("AppBundle:Customer");
        $customers = $repository->findAll();
        return $customers;
    }

    /**
     * Response with the customer that has {customer} for id
     *
     * @ApiDoc(
     *  section="Customer",
     *  description="Get a customer",
     *  requirements={
     *      {
     *          "name"="customer",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="customer id"
     *      }
     *  },
     *  output="AppBundle\Entity\Customer",
     *  statusCodes={
     *         200="Returned when successful"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function getAction(Customer $customer)
    {
        return $customer;
    }

    /**
     * Create a new customer
     *
     * @ApiDoc(
     *  section="Customer",
     *  description="Create a new Customer",
     *  input="AppBundle\Form\CustomerType",
     *  output="AppBundle\Entity\Customer",
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
        $customer = new Customer();
        $customerForm = $this->createForm(new CustomerType(), $customer);

        $customerForm->handleRequest($request);

        if ($customerForm->isValid()) {
            $registrationHandler = $this->get('mum.handler.customer.registration');
            $attempt = $registrationHandler->handle($customer);
            return [
                'customer' => $attempt->getCustomer()->getId(),
                'attempt' => $attempt->getId()
            ];
        }

        return $customerForm->getErrors();
    }
}
