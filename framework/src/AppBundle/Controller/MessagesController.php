<?php

namespace AppBundle\Controller;

use AppBundle\Form\EmailMessageType;
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
        return [
            'body' => $form->get('message')->get('body')->getData(),
            'at' => $form->get('message')->get('at')->getData(),
            'receivers' => json_decode($form->get('message')->get('receivers')->getData(), true)
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
     * Send a new email message
     *
     * @param Request $request
     * @return MessageSent|\Symfony\Component\Form\FormErrorIterator
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
     *         200="Returned when successful"
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
            $messageStore = $this->get('mum.message.store');
            $response = $messageStore->storeEmailMessage(
                $this->getUser(),
                $data['message']['body'],
                $data['message']['at'],
                $data['message']['receivers'],
                $data['about'],
                $data['from']);
            return new MessageSent($response);
        }

        return $emailMessageForm->getErrors();
    }
}
