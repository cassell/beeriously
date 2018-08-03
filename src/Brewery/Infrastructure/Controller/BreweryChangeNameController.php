<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Brewer\Infrastructure\Roles;
use Beeriously\Brewery\Domain\BreweryName;
use Beeriously\Brewery\Infrastructure\Form\BreweryName\BreweryChangeNameFormType;
use Beeriously\Brewery\Infrastructure\Form\BreweryName\ChangeNameFormData;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Universal\Exception\SafeMessageException;
use Beeriously\Universal\Time\OccurredOn;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BreweryChangeNameController extends AbstractController
{
    /**
     * @Route("/brewery/changeName", name="brewery-change-name", methods={"GET","POST"})
     */
    public function changeNameRemoteForm(
        Request $request
    ) {
        $this->denyAccessUnlessGranted(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT);

        $brewery = $this->getUser()->getBrewery();

        $changeNameFormData = new ChangeNameFormData($brewery->getName()->getValue());

        $form = $this->createForm(BreweryChangeNameFormType::class, $changeNameFormData,
            [
                'action' => $this->generateUrl('brewery-change-name', []),
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $brewery->changeName(
                    new BreweryName($changeNameFormData->getName()),
                    $this->getUser(),
                    OccurredOn::now()
                );

                $this->flush();
                $this->dispatchEvents($brewery->releaseEvents());

                $this->addSuccessMessage('beeriously.brewery.name_changed');
            } catch (SafeMessageException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }

            return $this->redirectToRoute('brewery');
        }

        return $this->renderRemoteForm('brewery/details/partial/change-name-remote-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
