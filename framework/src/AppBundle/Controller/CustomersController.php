<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomerProfile;
use AppBundle\Entity\RegistrationAttempt;
use AppBundle\Form\CustomerProfileType;
use AppBundle\Form\CustomerType;
use AppBundle\ResponseObjects\Customer as ResponseCustomer;
use AppBundle\ResponseObjects\CustomerAuth;
use AppBundle\ResponseObjects\CustomerProfile as CustomerProfileResponse;
use AppBundle\ResponseObjects\CustomerRegistration;
use Customer\Registration\RegistrationAttemptStatusSent;
use FOS\RestBundle\Controller\Annotations as FOSRestBundleAnnotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
     * Create a new customer
     *
     * @param Request $request
     * @return CustomerRegistration|\Symfony\Component\Form\FormErrorIterator
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
            $response = $registrationHandler->register($customer);
            return new CustomerRegistration($response['customer'], $response['attempt']);
        }

        return $customerForm->getErrors();
    }

    /**
     * Confirm a customer
     *
     * @param Customer $customer
     * @param RegistrationAttempt $registrationAttempt
     * @return CustomerAuth
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
     *         500="Returned on not found customer",
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

        return new CustomerAuth($customer);
    }

    /**
     * Response with the customer that has {customer} for id
     *
     * @param Customer $customer
     * @return ResponseCustomer
     * @throws HttpException
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
     *         200="Returned when successful",
     *         500="Returned on not found customer"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function getAction(Customer $customer = null)
    {
        if (!$customer) {
            throw new HttpException(500, 'Customer not found');
        }

        return new ResponseCustomer($customer);
    }

    /**
     * Update customer profile
     *
     * @param Customer $customer
     * @param Request $request
     * @return string|\Symfony\Component\Form\FormErrorIterator
     * @throws HttpException
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Customer",
     *  description="Update customer profile",
     *  requirements={
     *      {
     *          "name"="customer",
     *          "dataType"="string",
     *          "requirement"="*",
     *          "description"="customer id"
     *      }
     *  },
     *  input="AppBundle\Form\CustomerProfileType",
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
    public function putProfileAction(Customer $customer = null, Request $request)
    {
        if (!$customer) {
            throw new HttpException(500, 'Customer not found');
        }

        $customerProfile = $customer->getProfile();

        if (!$customerProfile) {
            $customerProfile = new CustomerProfile();
        }

        $customerProfileForm = $this->createForm(new CustomerProfileType(), $customerProfile, array('method' => 'PUT'));

        $customerProfileForm->handleRequest($request);

        if ($customerProfileForm->isValid()) {
            $profileHandler = $this->get('mum.handler.customer.profile');
            $profileHandler->update($customer,
                $customerProfile,
                $customerProfileForm->get('avatarData')->getData(),
                $customerProfileForm->get('avatarMimeType')->getData());
            return new CustomerProfileResponse($customerProfile);
        }

        return $customerProfileForm->getErrors();
    }
}
