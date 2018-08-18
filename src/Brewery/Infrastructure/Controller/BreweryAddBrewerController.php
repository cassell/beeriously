<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Domain\Exception\BrewerAccountAlreadyExistsException;
use Beeriously\Brewer\Infrastructure\Roles;
use Beeriously\Brewery\Infrastructure\Form\AddBrewer\AddBrewerFormType;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Universal\Exception\SafeMessageException;
use Beeriously\Universal\Time\OccurredOn;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use FOS\UserBundle\Util\UserManipulator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BreweryAddBrewerController extends AbstractController
{
    /**
     * @Route("/brewery/addBrewer", name="brewery-add-brewer-form", methods={"GET","POST"})
     */
    public function addBrewerRemoteForm(
        Request $request,
        UserManipulator $userManipulator,
        MailerInterface $mailer,
        TokenGeneratorInterface $tokenGenerator
    ) {
        $this->denyAccessUnlessGranted(Roles::ROLE_OWNER_OF_BREWERY_ACCOUNT);

        $newBrewer = new Brewer();
        $newBrewer->setPlainPassword(Uuid::uuid4()->toString());

        $brewery = $this->getUser()->getBrewery();

        $form = $this->createForm(AddBrewerFormType::class, $newBrewer,
            [
                'action' => $this->generateUrl('brewery-add-brewer-form', []),
                'cancel_action' => $this->generateUrl('brewery'),
                'cancel_button_align_right' => true,
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()) {
                try {
                    try {
                        $name = $newBrewer->getFullName();

                        $newBrewer = $userManipulator->create($newBrewer->getUsername(),
                            Uuid::uuid4()->toString(),
                            $newBrewer->getEmail(),
                            true,
                            false
                        );

                        if (!$newBrewer instanceof Brewer) {
                            throw new \RuntimeException();
                        }

                        $newBrewer->setFirstName($name->getFirstName()->getValue());
                        $newBrewer->setLastName($name->getLastName()->getValue());

                        $brewery->addAssistantBrewer($newBrewer, $this->getUser(), OccurredOn::now());

                        $this->addSuccessMessage('beeriously.brewery.brewer_added_successfully');

                        // copied from EmailConfirmationListener::onRegistrationSuccess
                        $newBrewer->setConfirmationToken($tokenGenerator->generateToken());

                        $mailer->sendConfirmationEmailMessage($newBrewer);

                        $this->flush();

                        $userManipulator->addRole($newBrewer->getUsername(), Roles::ROLE_BREWER);

                        $this->dispatchEvents($brewery->releaseEvents());

                        return $this->redirectToRoute('brewery');
                    } catch (UniqueConstraintViolationException $exception) {
                        throw new BrewerAccountAlreadyExistsException($exception);
                    }
                } catch (SafeMessageException $exception) {
                    $this->addErrorMessage($exception->getMessage());
                }
            } else {
                foreach($form->getErrors(true, false)->getChildren() as $error) {
                    $this->addErrorMessage($error->getMessage());
                }
            }

            return $this->redirectToRoute('brewery');
        }

        return $this->renderRemoteForm('brewery/details/partial/add-brewer-remote-form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
