<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\Twig;

use Symfony\Component\Translation\TranslatorInterface;
use Twig_SimpleFunction;

class TwigTranslateDateTimeHelper extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('translate_datetime', [$this, 'translateDatetime']),
        ];
    }

    public function translateDatetime($object): string
    {
        if (!$object instanceof \DateTimeImmutable) {
            throw new \RuntimeException();
        }

        return $object->format($this->translator->trans('beeriously.global.datetime_format'));
    }
}
