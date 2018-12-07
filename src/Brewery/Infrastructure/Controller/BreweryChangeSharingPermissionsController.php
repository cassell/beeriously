<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Brewer\Infrastructure\Roles;
use Beeriously\Brewery\BrewerySharingPreferences;
use Beeriously\Brewery\Infrastructure\Form\SharingPreferences\SharingPreferencesData;
use Beeriously\Brewery\Infrastructure\Form\SharingPreferences\SharingPreferencesFormType;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Universal\Exception\SafeMessageException;
use Beeriously\Universal\Time\OccurredOn;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BreweryChangeSharingPermissionsController extends AbstractController
{
    /**
     * @Route("/brewery/sharing", name="brewery-change-sharing", methods={"GET","POST"})
     */
    public function changeNameRemoteForm(
        Request $request
    ) {
        $this->denyAccessUnlessGranted(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT);

        $brewery = $this->getBrewery();

        $sharingData = SharingPreferencesData::fromBrewery($brewery);

        $form = $this->createForm(SharingPreferencesFormType::class, $sharingData,
            [
                'action' => $this->generateUrl('brewery-change-sharing', []),
                'cancel_action' => $this->generateUrl('brewery', []),
                'cancel_button_align_right' => true,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prefs = BrewerySharingPreferences::defaultNotSharing();
            if ($sharingData->shouldShareTapList()) {
                $prefs->shareTapList();
            }

            try {
                $brewery->updatePreferences(
                    $prefs,
                    $this->getUser(),
                    OccurredOn::now()
                );

                $this->flush();
                $this->dispatchEvents($brewery->releaseEvents());

                $this->addSuccessMessage('beeriously.brewery.preferences_updated');
            } catch (SafeMessageException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }

            return $this->redirectToRoute('brewery');
        }

        return $this->render('brewery/change-sharing.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
