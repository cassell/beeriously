<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Photo;

use Ornicar\GravatarBundle\Templating\Helper\GravatarHelperInterface;

class GravatarPhotoService implements GravatarPhotoServiceInterface
{
    /**
     * @var GravatarHelperInterface
     */
    private $gravatarHelper;
    /**
     * @var int
     */
    private $defaultSize;
    /**
     * @var string
     */
    private $defaultRating;
    /**
     * @var string
     */
    private $defaultPhotoType;
    /**
     * @var bool
     */
    private $defaultSecure;

    public function __construct(GravatarHelperInterface $gravatarHelper,
                                int $defaultSize,
                                string $defaultRating,
                                string $defaultPhotoType,
                                bool $defaultSecure
    ) {
        $this->gravatarHelper = $gravatarHelper;
        $this->defaultSize = $defaultSize;
        $this->defaultRating = $defaultRating;
        $this->defaultPhotoType = $defaultPhotoType;
        $this->defaultSecure = $defaultSecure;
    }

    public function getUrlForEmail(string $email): string
    {
        return $this->gravatarHelper->getUrl($email, $this->defaultSize, $this->defaultRating, $this->defaultPhotoType, $this->defaultSecure);
    }
}
