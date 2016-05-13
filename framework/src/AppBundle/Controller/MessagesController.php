<?php

namespace AppBundle\Controller;

use AppBundle\Form\EmailMessageType;
use AppBundle\Form\InstantMessageType;
use AppBundle\Form\SMSMessageType;
use AppBundle\ResponseObjects\MessageSent;
use FOS\RestBundle\Controller\Annotations as FOSRestBundleAnnotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class MessafeController
 *
 * @package AppBundle\Controller
 *
 * @FOSRestBundleAnnotations\View()
 */
class MessagesController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Extract the message common data from form
     *
     * @param Form $form
     * @return array
     */
    private function collectMessageDataFromForm(Form $form)
    {
        $body = $form->get('message')->get('body')->getData();
        $at = $form->get('message')->get('at')->getData();
        $now = new \DateTime('now');
        if ($at && $at < $now) {
            throw new HttpException(500, 'Scheduled Message needs to be some where in the future');
        }

        $receivers = json_decode($form->get('message')->get('receivers')->getData(), true);
        if (!is_array($receivers)) {
            throw new HttpException(500, 'Receivers are wrong formatted');
        }
        
        $fileData = $form->get('message')->get('fileData')->getData();
        $fileMimeType = $form->get('message')->get('fileMimeType')->getData();                
        
        if($fileData != null && $fileMimeType != null) {
            
            $mimeType = array('jpg', 'jpeg', 'doc', 'excel', 'pdf');
            if (!in_array($fileMimeType, $mimeType)) {
                throw new HttpException(500, 'File Mime Type must be: jpg, jpeg, doc, excel or pdf');
            }
            
            $fileHandler = $this->get('mum.customer.files');
            $attachment = $fileHandler->upload($fileData, $fileMimeType);

            if($body == null || $body == ""){
                $body = $attachment;
            }

        }else{
            $attachment = null;
        }

        return [
            'body' => $body,
            'attachment' => $attachment,
            'at' => $form->get('message')->get('at')->getData(),
            'receivers' => $receivers
        ];
    }

    /**
     * Extract the email message data from form
     *
     * @param Form $form
     * @return array
     */
    private function collectEmailMessageDataFromForm(Form $form)
    {
        return [
            'message' => $this->collectMessageDataFromForm($form),
            'about' => $form->get('about')->getData(),
            'from' => $form->get('from')->getData()
        ];
    }

    /**
     * Extract the sms message data from form
     *
     * @param Form $form
     * @return array
     */
    private function collectSMSMessageDataFromForm(Form $form)
    {
        return [
            'message' => $this->collectMessageDataFromForm($form)
        ];
    }

    /**
     * Extract the instant message data from form
     *
     * @param Form $form
     * @return array
     */
    private function collectInstantMessageDataFromForm(Form $form)
    {
        return [
            'message' => $this->collectMessageDataFromForm($form)
        ];
    }

    /**
     * Handle the message
     *
     * @param array $data
     * @param string $serviceHandlerName
     * @return MessageSent
     */
    private function handleMessage(Array $data, $serviceHandlerName)
    {
        $messageDispatcher = $this->get('mum.message.dispatcher');
        $response = $messageDispatcher->handleMessage($this->getUser(), $data, $serviceHandlerName);
        return new MessageSent($response['message'], $response['delivered']);
    }

    /**
     * Send a new email message
     *
     * @param Request $request
     * @return MessageSent|\Symfony\Component\Form\FormErrorIterator
     * @throws HttpException
     *
     * @FOSRestBundleAnnotations\Route("/messages/email")
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Message",
     *  description="Send a new email message",
     *  input="AppBundle\Form\EmailMessageType",
     *  statusCodes={
     *         200="Returned when successful",
     *         500="Returned on scheduled message not valid trigger"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function postEmailAction(Request $request)
    {
        $emailMessageForm = $this->createForm(new EmailMessageType());

        $emailMessageForm->handleRequest($request);

        if ($emailMessageForm->isValid()) {
            $data = $this->collectEmailMessageDataFromForm($emailMessageForm);
            return $this->handleMessage($data, 'Email');
        }

        return $emailMessageForm->getErrors();
    }

    /**
     * Send a new sms message
     *
     * @param Request $request
     * @return MessageSent|\Symfony\Component\Form\FormErrorIterator
     * @throws HttpException
     *
     * @FOSRestBundleAnnotations\Route("/messages/sms")
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Message",
     *  description="Send a new sms message",
     *  input="AppBundle\Form\SMSMessageType",
     *  statusCodes={
     *         200="Returned when successful",
     *         500="Returned on scheduled message not valid trigger"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function postSMSAction(Request $request)
    {
        $smsMessageForm = $this->createForm(new SMSMessageType());

        $smsMessageForm->handleRequest($request);

        if ($smsMessageForm->isValid()) {
            $data = $this->collectSMSMessageDataFromForm($smsMessageForm);
            return $this->handleMessage($data, 'SMS');
        }

        return $smsMessageForm->getErrors();
    }

    /**
     * Send a new instant message
     *
     * @param Request $request
     * @return MessageSent|\Symfony\Component\Form\FormErrorIterator
     * @throws HttpException
     *
     * @FOSRestBundleAnnotations\Route("/messages/instant")
     *
     * @Security("has_role('ROLE_USER')")
     *
     * @ApiDoc(
     *  section="Message",
     *  description="Send a new instant message",
     *  input="AppBundle\Form\InstantMessageType",
     *  statusCodes={
     *         200="Returned when successful",
     *         500="Returned on scheduled message not valid trigger"
     *  },
     *  tags={
     *   "stable" = "#4A7023",
     *   "v1" = "#ff0000"
     *  }
     * )
     */
    public function postInstantAction(Request $request)
    {
        $instantMessageForm = $this->createForm(new InstantMessageType());

        $instantMessageForm->handleRequest($request);

        if ($instantMessageForm->isValid()) {
            $data = $this->collectInstantMessageDataFromForm($instantMessageForm);
            return $this->handleMessage($data, 'Instant');
        }

        return $instantMessageForm->getErrors();
    }
}
