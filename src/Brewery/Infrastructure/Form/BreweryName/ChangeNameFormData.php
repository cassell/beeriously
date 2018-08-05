<?php

declare(strict_types=1);

namespace Beeriously\Brewery\Infrastructure\Form\BreweryName;

class ChangeNameFormData
{
    /**
     * @var string
     */
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
