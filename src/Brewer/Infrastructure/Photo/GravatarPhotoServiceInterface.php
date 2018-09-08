<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Infrastructure\Photo;

interface GravatarPhotoServiceInterface
{
    public function getUrlForEmail(string $email): string;
}
