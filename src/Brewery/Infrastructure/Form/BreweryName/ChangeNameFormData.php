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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = (string) $name;
    }
}
