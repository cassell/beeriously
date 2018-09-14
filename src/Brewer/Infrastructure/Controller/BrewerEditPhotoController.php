<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Controller;

use Beeriously\Brewer\Infrastructure\Form\BrewerChangeAvatarFormData;
use Beeriously\Brewer\Infrastructure\Form\BrewerChangeAvatarFormType;
use Beeriously\Infrastructure\Controller\AbstractController;
use Beeriously\Infrastructure\File\FileTransportToUploadStorageServiceInterface;
use Beeriously\Universal\Exception\SafeMessageException;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BrewerEditPhotoController extends AbstractController
{
    /**
     * @Route("/brewer/avatar/change", name="brewer-change-avatar", methods={"GET","POST"})
     */
    public function changeBrewerAvatar(
        Request $request,
        FileTransportToUploadStorageServiceInterface $transportToUploadStorageService,
        ImageManager $imageManager
    ) {
        $fileUploadObject = new BrewerChangeAvatarFormData();

        $form = $this->createForm(BrewerChangeAvatarFormType::class, $fileUploadObject, [
            'cancel_action' => $this->generateUrl('fos_user_profile_show'),
            'cancel_button_align_right' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $avatar = $fileUploadObject->getAvatar();

                if (null === $avatar) {
                    throw new InvalidFileException();
                }

                $realPath = $avatar->getRealPath();

                $jpegThumbnailStream = $imageManager->make($realPath)->fit(200)->stream('jpg', 60);
                $key = $transportToUploadStorageService->transportToStorage(
                    'user.jpg',
                    'image/jpeg',
                    $jpegThumbnailStream->getContents()
                );
                $jpegThumbnailStream->close();

                $this->getUser()->setProfilePhotoKey($key);

                $this->flush();

                $this->addSuccessMessage('beeriously.profile.photo_changed_successfully');

                return $this->redirect($this->generateUrl('fos_user_profile_show'));
            } catch (SafeMessageException $exception) {
                $this->addErrorMessage($exception->getMessage());
            }
        }

        return $this->render('brewer/change-photo.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
