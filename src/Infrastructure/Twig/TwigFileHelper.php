<?php

declare(strict_types=1);

//See: https://stackoverflow.com/questions/22550368/how-can-we-get-class-name-of-the-entity-object-in-twig-view

namespace Beeriously\Infrastructure\Twig;

use Twig_SimpleFunction;

class TwigFileHelper extends \Twig_Extension
{
    /**
     * @var string
     */
    private $prefix;

    public function __construct(string $prefix)
    {
        $this->prefix = $prefix;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('beeriously_file', [$this, 'getS3Path']),
        ];
    }

    public function getS3Path(string $key): string
    {
        return $this->prefix.$key;
    }
}
