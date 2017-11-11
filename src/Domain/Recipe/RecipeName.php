<?php

namespace Beeriously\Domain\Recipe;

class RecipeName
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new InvalidRecipeNameException("Recipe name can not be empty.");
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

}
