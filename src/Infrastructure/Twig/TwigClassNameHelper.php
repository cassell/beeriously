<?php
declare(strict_types=1);

//See: https://stackoverflow.com/questions/22550368/how-can-we-get-class-name-of-the-entity-object-in-twig-view

namespace Beeriously\Infrastructure\Twig;

use ReflectionClass;
use Twig_SimpleFunction;

class TwigClassNameHelper extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('class_name', [$this, 'getClassName']),
        ];
    }

    public function getClassName($object): string
    {
        return (new ReflectionClass($object))->getShortName();
    }

}