<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Form\ChangeLogo;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class BreweryChangeLogoFormData
{
    /**
     * @Assert\NotBlank()
     * @Assert\File(mimeTypes={ "image/jpeg","image/png","image/gif" })
     */
    private $logo;

    public function getLogo(): ?UploadedFile
    {
        return $this->logo;
    }

    public function setLogo($avatar)
    {
        $this->logo = $avatar;

        return $this;
    }
}
