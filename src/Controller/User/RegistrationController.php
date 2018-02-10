<?php

declare(strict_types=1);

namespace Beeriously\Controller\User;

use Beeriously\Domain\Brewers\Brewer;
use Beeriously\Domain\Brewers\FirstName;
use Beeriously\Domain\Brewers\FullName;
use Beeriously\Domain\Brewers\LastName;
use Beeriously\Domain\Brewers\Preference\Density\DensityPreferences;
use Beeriously\Domain\Brewers\Preference\MassVolume\MassVolumePreferences;
use Beeriously\Domain\Brewers\Preference\Temperature\TemperaturePreferences;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends \FOS\UserBundle\Controller\RegistrationController
{
    public function registerAction(Request $request)
    {
        throw new \RuntimeException('Overridden');
    }

    /**
     * @Route("/register/", name="fos_user_registration_register", methods={"GET","POST"})
     */
    public function registerNewUserAction(Request $request,
                                          MassVolumePreferences $massVolumePreferences,
                                          DensityPreferences $densityPreferences,
                                          TemperaturePreferences $temperaturePreferences
    ) {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        /** @var Brewer $user */
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
            try {
                $firstName = new FirstName($request->get('_firstName'));
                $lastName = new LastName($request->get('_lastName'));
                $fullName = new FullName($firstName, $lastName);
                $massVolumePreference = $massVolumePreferences->fromCode($request->get('_mass_volume'));
                $densityPreference = $densityPreferences->fromCode($request->get('_density'));
                $temperaturePreference = $temperaturePreferences->fromCode($request->get('_temperature'));
                $user->completeRegistrationBecauseFriendsOfSymfonyUserBundleDoesNotLikeAdditionalConstructorParameters($fullName, $massVolumePreference, $densityPreference, $temperaturePreference);
            } catch (\Exception $e) {
                $form->addError(new FormError($e->getMessage()));
            }

            if ($form->isValid() && count($form->getErrors()) < 1) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $response = new RedirectResponse($this->generateUrl('fos_user_registration_confirmed'));
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

        $massVolumeUnits = [];
        foreach ($massVolumePreferences as $massVolumePreference) {
            $massVolumeUnits[$massVolumePreference->getCode()] = $massVolumePreference->getTranslationDescriptionIdentifier();
        }

        $temperatureUnits = [];
        foreach ($temperaturePreferences as $temperaturePreference) {
            $temperatureUnits[$temperaturePreference->getCode()] = $temperaturePreference->getTranslationDescriptionIdentifier();
        }

        $densityUnits = [];
        foreach ($densityPreferences as $densityPreference) {
            $densityUnits[$densityPreference->getCode()] = $densityPreference->getTranslationDescriptionIdentifier();
        }

        return $this->render('user/security/register/register.html.twig', [
            'form' => $form->createView(),
            'massVolumeUnits' => $massVolumeUnits,
            'temperatureUnits' => $temperatureUnits,
            'densityUnits' => $densityUnits,
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
     * @Route("/register/confirmed", name="fos_user_registration_confirmed", methods={"GET","POST"})
     */
    public function confirmedAction()
    {
        if ($this->getUser()->hasRole(Brewer::ROLE_VALID_BREWER)) {
            return new RedirectResponse($this->generateUrl('dashboard'));
        }

        return new RedirectResponse($this->generateUrl('fos_user_registration_register'));
    }
}
