<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Controller;

use Beeriously\Brewer\Infrastructure\Controller\InvalidFileException;
use Beeriously\Brewery\Infrastructure\Form\ChangeLogo\BreweryChangeLogoFormData;
use Beeriously\Brewery\Infrastructure\Form\ChangeLogo\BreweryChangeLogoFormType;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Infrastructure\File\FileTransportToUploadStorageServiceInterface;
use Beeriously\Universal\Exception\SafeMessageException;
use Beeriously\Universal\Time\OccurredOn;
use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BreweryChangeLogoController extends AbstractController
{
    /**
     * @Route("/brewery/logo/change", name="brewery-change-logo", methods={"GET","POST"})
     */
    public function changeBrewerAvatar(
        Request $request,
        FileTransportToUploadStorageServiceInterface $transportToUploadStorageService,
        ImageManager $imageManager
    ) {
        $fileUploadObject = new BreweryChangeLogoFormData();

        $form = $this->createForm(BreweryChangeLogoFormType::class, $fileUploadObject, [
            'cancel_action' => $this->generateUrl('brewery'),
            'cancel_button_align_right' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $logo = $fileUploadObject->getLogo();

                if (null === $logo) {
                    throw new InvalidFileException();
                }

                $realPath = $logo->getRealPath();

                $pngStream = $imageManager->make($realPath)->resize(800, 400, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                })->stream('png');
                $key = $transportToUploadStorageService->transportToStorage(
                    'logo.png',
                    'image/png',
                    $pngStream->getContents()
                );
                $pngStream->close();

                $this->getBrewery()->setLogoPhotoKey($key, $this->getUser(), OccurredOn::now());

                $this->flush();

                $this->addSuccessMessage('beeriously.brewery.logo_changed_successfully');

                return $this->redirect($this->generateUrl('brewery'));
            } catch (SafeMessageException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('brewery/change-logo.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
