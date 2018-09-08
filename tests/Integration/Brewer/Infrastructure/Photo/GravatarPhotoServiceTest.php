<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewer\Infrastructure\Photo;

use Beeriously\Brewer\Infrastructure\Photo\GravatarPhotoServiceInterface;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;

class GravatarPhotoServiceTest extends ContainerAwareTestCase
{
    public function testGetUrlForEmail()
    {
        $this->assertEquals('https://secure.gravatar.com/avatar/8ae80c10e80aeebb14c7cd1092e4d410?s=200&r=g&d=identicon', $this->getPhotoService()->getUrlForEmail('support@beeriously.com'));
    }

    private function getPhotoService(): GravatarPhotoServiceInterface
    {
        /** @var GravatarPhotoServiceInterface $service */
        $service = $this->get('test.'.GravatarPhotoServiceInterface::class);

        return $service;
    }
}
