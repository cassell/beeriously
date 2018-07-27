<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewery\Infrastructure\Form\RemoveBrewer\RemoveBrewerModalFormType;
use Beeriously\Brewery\Infrastructure\Service\RemoveBrewerFromBreweryService;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Universal\Exception\InvalidBrowserStateRuntimeException;
use Beeriously\Universal\Time\OccurredOn;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BreweryUserController extends AbstractController
{
    /**
     * @Route("/brewery/brewer/{id}/deleteModal", name="brewery-delete-brewer-modal", methods={"GET","POST"})
     */
    public function deleteBrewerModal(
        Brewer $brewer,
        Request $request,
        RemoveBrewerFromBreweryService $service
    ) {
        $brewery = $this->getUser()->getBrewery();

        if (!$brewer->isEnabled()) {
            throw new InvalidBrowserStateRuntimeException();
        }

        $form = $this->createForm(RemoveBrewerModalFormType::class, $brewer,
            [
                'action' => $this->generateUrl('brewery-delete-brewer-modal', [
                    'id' => $brewer->getId(),
                ]),
            ]);

        if (!$this->formHandle($form, $request)) {
            return $this->renderConfirmForm($form);
        }

        $service->removeAssistantBrewerFromBrewery($brewer, $brewery, $this->getUser(),OccurredOn::now());

        $this->addSuccessMessage('beeriously.brewery.brewer_removed_successfully');

        return $this->redirectToRoute('brewery');
    }

    private function renderConfirmForm(FormInterface $form): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('form/confirm-modal-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function formHandle(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        return $form->isSubmitted() && $form->isValid();
    }
}
