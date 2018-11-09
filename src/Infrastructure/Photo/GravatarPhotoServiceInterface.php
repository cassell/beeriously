<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Photo;

interface GravatarPhotoServiceInterface
{
    public function getUrlForEmail(string $email): string;
}
