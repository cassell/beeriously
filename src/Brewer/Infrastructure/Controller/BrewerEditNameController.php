<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Controller;

use Beeriously\Brewer\Infrastructure\Form\BrewerChangeNameFormType;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Universal\Exception\SafeMessageException;
use Beeriously\Universal\Time\OccurredOn;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BrewerEditNameController extends AbstractController
{
    /**
     * @Route("/brewer/name/change", name="brewer-change-name", methods={"GET","POST"})
     */
    public function changeBrewerName(
        Request $request,
        UserManipulator $userManipulator
    ) {
        $form = $this->createForm(BrewerChangeNameFormType::class, $this->getUser(), [
            'cancel_action' => $this->generateUrl('fos_user_profile_show'),
            'cancel_button_align_right' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->getBrewery()->recordBrewerNameChanged(
                    $this->getUser(),
                    $this->getUser(),
                    OccurredOn::now()
                );

                $this->flush();

                $this->addSuccessMessage('beeriously.profile.name_changed_successfully');

                return $this->redirect($this->generateUrl('fos_user_profile_show'));
            } catch (SafeMessageException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('brewer/change-name.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
