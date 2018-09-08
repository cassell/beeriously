<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Listener;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Infrastructure\DoctrineBrewerRepository;
use Beeriously\Brewer\Infrastructure\Photo\GravatarPhotoServiceInterface;
use Beeriously\Brewery\Domain\Event\BrewerWasAddedToBrewery;
use Beeriously\Infrastructure\File\FileTransportToUploadStorageServiceInterface;
use Beeriously\Universal\Event\Dispatcher;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Util\UserManipulator;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GrabProfileImageFromGravatarWhenUserIsActivatedListener implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var UserManipulator
     */
    private $userManipulator;

    /**
     * @var GravatarPhotoServiceInterface
     */
    private $gravatarPhotoService;

    /**
     * @var FileTransportToUploadStorageServiceInterface
     */
    private $fileService;

    /**
     * @var Client
     */
    private $guzzle;

    /**
     * @var DoctrineBrewerRepository
     */
    private $brewerRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                DoctrineBrewerRepository $brewerRepository,
                                Dispatcher $dispatcher,
                                UserManipulator $userManipulator,
                                GravatarPhotoServiceInterface $gravatarPhotoService,
                                Client $guzzle,
                                FileTransportToUploadStorageServiceInterface $fileService
    ) {
        $this->entityManager = $entityManager;
        $this->brewerRepository = $brewerRepository;
        $this->dispatcher = $dispatcher;
        $this->userManipulator = $userManipulator;
        $this->gravatarPhotoService = $gravatarPhotoService;
        $this->fileService = $fileService;
        $this->guzzle = $guzzle;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
            BrewerWasAddedToBrewery::class => 'onBrewerAddedToBrewery',
        ];
    }

    public function onBrewerAddedToBrewery(BrewerWasAddedToBrewery $event)
    {
        /** @var Brewer $brewer */
        $brewer = $this->brewerRepository->find($event->getBrewerAddedId()->getValue());

        $this->updatePhotoFromGravatar($brewer);
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        /** @var Brewer $brewer */
        $brewer = $event->getUser();

        $this->updatePhotoFromGravatar($brewer);
    }

    private function updatePhotoFromGravatar(Brewer $brewer): void
    {
        $urlForEmail = $this->gravatarPhotoService->getUrlForEmail($brewer->getEmail());

        try {
            $response = $this->guzzle->get($urlForEmail);

            if (!$response->hasHeader('content-type')) {
                throw new TransferException();
            }

            $fileType = $response->getHeader('content-type')[0];

            if ('image/png' === $fileType) {
                $fileName = 'user.png';
            } elseif ('image/jpeg' === $fileType) {
                $fileName = 'user.jpeg';
            } else {
                throw  new \RuntimeException('unknown Gravatar type');
            }

            $fileContents = (string) $response->getBody();
        } catch (GuzzleException $guzzleException) {
            $fileType = 'image/png';
            $fileName = 'user.png';
            $fileContents = \file_get_contents(__DIR__.'/../../../../data/assets/default_user.png');
        }

        $key = $this->fileService->transportToStorage($fileName, $fileType, $fileContents);

        $brewer->setProfilePhotoKey($key);

        $this->entityManager->persist($brewer);
        $this->entityManager->flush();
    }
}
