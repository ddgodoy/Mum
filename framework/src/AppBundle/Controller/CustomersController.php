<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\RegistrationAttempt;
use AppBundle\Form\CustomerType;
use AppBundle\ResponseObjects\Customer as ResponseCustomer;
use Customer\Registration\RegistrationAttemptStatusSent;
use FOS\RestBundle\Controller\Annotations as FOSRestBundleAnnotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class CustomersController
 *
 * @package AppBundle\Controller
 *
 * @FOSRestBundleAnnotations\View()
 */
class CustomersController extends FOSRestController implements ClassResourceInterface
{

    /**
     * Response with the customer that has {customer} for id
     *
     * @param Customer $customer
     * @return Customer
     *
     * @Security("has_role('ROLE_USER')")
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
        return new ResponseCustomer($customer);
    }

    /**
     * Create a new customer
     *
     * @param Request $request
     * @return array|\Symfony\Component\Form\FormErrorIterator
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
            $attempt = $registrationHandler->register($customer);
            return [
                'customer' => $attempt->getCustomer()->getId(),
                'attempt' => $attempt->getId()
            ];
        }

        return $customerForm->getErrors();
    }

    /**
     * Confirm a customer
     *
     * @param Customer $customer
     * @param RegistrationAttempt $registrationAttempt
     * @return array
     * @throws HttpException
     *
     * @ParamConverter("registrationAttempt", class="AppBundle:RegistrationAttempt", options={
     *     "mapping": {
     *          "confirmation_code": "token",
     *          "customer": "customer"
     *      }
     *     })
     *
     * @FOSRestBundleAnnotations\Route("/customers/{customer}/confirms/{confirmation_code}")
     *
     * @ApiDoc(
     *  section="Customer",
     *  description="Validate a customer",
     *  requirements={
     *      {
     *          "name"="customer",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="customer id"
     *      },
     *     {
     *          "name"="confirmation_code",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="confirmation numeric code sent by sms"
     *      }
     *  },
     *  statusCodes={
     *         200="Returned when successful",
     *         500="Returned on invalid confirmation code"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function postConfirmAction(Customer $customer = null, RegistrationAttempt $registrationAttempt = null)
    {
        if (!$customer) {
            throw new HttpException(500, 'Customer not found');
        }

        if (!$registrationAttempt || $registrationAttempt->getStatus() !== (new RegistrationAttemptStatusSent())->getId()) {
            throw new HttpException(500, 'Confirmation code not valid');
        }

        $registrationHandler = $this->get('mum.handler.customer.registration');
        $registrationHandler->confirm($customer, $registrationAttempt);

        return [
            'username' => $customer->getUsername(),
            'password' => $customer->getPassword()
        ];
    }
}
