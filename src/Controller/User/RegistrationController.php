<?php

declare(strict_types=1);

namespace Beeriously\Controller\User;

use Beeriously\Domain\Brewers\Brewer;
use Beeriously\Domain\Brewers\FirstName;
use Beeriously\Domain\Brewers\FullName;
use Beeriously\Domain\Brewers\LastName;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends \FOS\UserBundle\Controller\RegistrationController
{
    /**
     * @Route("/register/", name="fos_user_registration_register", methods={"GET","POST"})
     */
    public function registerAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $response = new RedirectResponse('/register/details');
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('user/security/register/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/check-email", name="fos_user_registration_check_email", methods={"GET"})
     */
    public function checkEmailAction()
    {
        return parent::checkEmailAction();
    }

    /**
     * @Route("/register/confirm/{token}", name="fos_user_registration_confirm", methods={"GET"})
     */
    public function confirmAction(Request $request, $token)
    {
        return parent::confirmAction($request, $token);
    }

    /**
     * @Route("/register/details", name="user_registration_confirm", methods={"GET","POST"})
     */
    public function moreDetails(Request $request)
    {
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        /** @var Brewer $user */
        $user = $this->getUser();

        if ($user->hasRole(Brewer::ROLE_VALID_BREWER)) {
            return new RedirectResponse('/');
        }

        if ($request->isMethod('POST')) {
            try {
                $firstName = new FirstName($request->get('_firstName'));
                $lastName = new LastName($request->get('_lastName'));
                $fullName = new FullName($firstName, $lastName);
                $user->completeRegistration($fullName);
                $this->getDoctrine()->getManager()->flush();
                $userManager->updateUser($user);

                return new RedirectResponse($this->generateUrl('fos_user_registration_confirmed'));
            } catch (\Exception $e) {
                // error
                throw $e;
            }
        }

        return $this->render('user/security/register/register-complete-details.html.twig');
    }

    /**
     * @Route("/register/confirmed", name="fos_user_registration_confirmed", methods={"GET","POST"})
     */
    public function confirmedAction()
    {
        if ($this->getUser()->hasRole(Brewer::ROLE_VALID_BREWER)) {
            return new RedirectResponse('/');
        }

        return new RedirectResponse('/register/details');
    }
}
