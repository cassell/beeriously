<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Domain\Exception\BrewerAccountAlreadyExistsException;
use Beeriously\Brewery\Domain\BreweryName;
use Beeriously\Brewery\Infrastructure\Form\AddBrewer\AddBrewerFormType;
use Beeriously\Brewery\Infrastructure\Form\BreweryName\BreweryChangeNameFormType;
use Beeriously\Brewery\Infrastructure\Form\BreweryName\ChangeNameFormData;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Universal\Event\Dispatcher;
use Beeriously\Universal\Exception\SafeMessageException;
use Beeriously\Universal\Identification\Identifier;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use FOS\UserBundle\Util\UserManipulator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @codeCoverageIgnore
 */
class BreweryController extends AbstractController
{
    public function __construct(Dispatcher $dispatcher)
    {
        parent::__construct($dispatcher);
    }

    /**
     * @Route("/brewery", name="brewery", methods={"GET","POST"})
     */
    public function view(\Symfony\Component\HttpFoundation\Request $request,
                         UserManipulator $userManipulator,
                         MailerInterface $mailer,
                         TokenGeneratorInterface $tokenGenerator)
    {
        $brewery = $this->getUser()->getBrewery();

        $changeNameFormData = new ChangeNameFormData($brewery->getName()->getValue());
        $changeNameForm = $this->get('form.factory')
            ->createNamedBuilder('change_name', BreweryChangeNameFormType::class, $changeNameFormData)
            ->getForm();

        $newBrewer = new Brewer();
        $addBrewerForm = $this->get('form.factory')
            ->createNamedBuilder('new_brewer', AddBrewerFormType::class, $newBrewer, [
                'cancel_action' => $this->generateUrl('brewery'),
                'cancel_button_align_right' => true,
            ])
            ->getForm();

        try {
            if ('POST' === $request->getMethod()) {
                if ($brewery->getAccountOwner() !== $this->getUser()) {
                    throw new AccessDeniedException();
                }

                if ($request->request->has($changeNameForm->getName())) {
                    $changeNameForm->handleRequest($request);

                    if ($changeNameForm->isSubmitted() && $changeNameForm->isValid()) {
                        $brewery->changeName(
                            new BreweryName($changeNameFormData->getName()),
                            OccurredOn::now()
                        );

                        $this->flush();
                        $this->dispatchEvents($brewery->releaseEvents());

                        $this->addSuccessMessage('beeriously.brewery.name_changed');
                    }

                    return $this->redirectToRoute('brewery');
                } elseif ($request->request->has($addBrewerForm->getName())) {
                    $addBrewerForm->handleRequest($request);

                    if ($addBrewerForm->isSubmitted() && $addBrewerForm->isValid()) {
                        try {
                            $name = $newBrewer->getFullName();

                            $newBrewer = $userManipulator->create($newBrewer->getUsername(),
                                Identifier::newId()->getValue(),
                                $newBrewer->getEmail(),
                                true,
                                false
                            );

                            if (!$newBrewer instanceof Brewer) {
                                throw new \RuntimeException();
                            }

                            $newBrewer->setFirstName($name->getFirstName()->getValue());
                            $newBrewer->setLastName($name->getLastName()->getValue());

                            $brewery->addAssistantBrewer($newBrewer, OccurredOn::now());

                            $this->addSuccessMessage('beeriously.brewery.brewer_added');

                            // copied from EmailConfirmationListener::onRegistrationSuccess
                            $newBrewer->setConfirmationToken($tokenGenerator->generateToken());

                            $mailer->sendConfirmationEmailMessage($newBrewer);

                            $this->flush();

                            $this->dispatchEvents($brewery->releaseEvents());

                            return $this->redirectToRoute('brewery');
                        } catch (UniqueConstraintViolationException $exception) {
                            throw new BrewerAccountAlreadyExistsException();
                        }
                    }
                }
            }
        } catch (SafeMessageException $exception) {
            $this->addErrorMessage($exception->getMessage());
        }

        return $this->render('brewery/brewery.html.twig', [
            'brewery' => $this->getUser()->getBrewery(),
            'changeNameForm' => $changeNameForm->createView(),
            'addBrewerForm' => $addBrewerForm->createView(),
        ]);
    }
}
