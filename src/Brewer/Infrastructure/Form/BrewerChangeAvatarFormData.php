<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Form;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class BrewerChangeAvatarFormData
{
    /**
     * @Assert\NotBlank()
     * @Assert\File(mimeTypes={ "image/jpeg","image/png","image/gif" })
     */
    private $avatar;

    public function getAvatar(): ?UploadedFile
    {
        return $this->avatar;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }
}
