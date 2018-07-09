<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Brewery\Domain\BreweryName;
use Beeriously\Brewery\Domain\Exception\BreweryNameCanNotBeEmptyException;
use Beeriously\Brewery\Domain\Exception\BreweryNameDidNotChangeException;
use Beeriously\Brewery\Infrastructure\Form\BreweryName\BreweryChangeNameFormType;
use Beeriously\Brewery\Infrastructure\Form\BreweryName\ChangeNameFormData;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Universal\Event\Events;
use Beeriously\Universal\Exception\SafeMessageException;
use Beeriously\Universal\Identification\String\NotEmptyStringException;
use Beeriously\Universal\Time\OccurredOn;
use http\Env\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @codeCoverageIgnore
 */
class BreweryController extends AbstractController
{
    /**
     * @Route("/brewery", name="brewery", methods={"GET","POST"})
     */
    public function view(\Symfony\Component\HttpFoundation\Request $request)
    {
        $brewery = $this->getUser()->getBrewery();

        $changeNameFormData = new ChangeNameFormData($brewery->getName()->getValue());
        $changeNameForm = $this->get('form.factory')
            ->createNamedBuilder('change_name',BreweryChangeNameFormType::class,$changeNameFormData)
            ->getForm();

        try {
            if('POST' === $request->getMethod()) {

                if($brewery->getAccountOwner() !== $this->getUser()) {
                    throw new AccessDeniedException();
                }

                if($request->request->has($changeNameForm->getName())) {

                    $changeNameForm->handleRequest($request);

                    $brewery->changeName(
                        new BreweryName($changeNameFormData->getName()),
                        OccurredOn::now()
                    );

                    $this->flush();
                    $this->dispatchEvents($brewery->releaseEvents());

                    $this->addSuccessMessage('beeriously.brewery.name_changed');
                    return $this->redirectToRoute('brewery');
                }

            }
        } catch (SafeMessageException $exception) {

            $this->addErrorMessage($exception->getMessage());

        }

        return $this->render('brewery/brewery.html.twig', [
            'brewery' => $this->getUser()->getBrewery(),
            'changeNameForm' => $changeNameForm->createView()
        ]);
    }


}
