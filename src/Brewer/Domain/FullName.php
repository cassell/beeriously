<?php

declare(strict_types=1);

namespace Beeriously\Brewer\Domain;

class FullName
{
    /**
     * @var FirstName
     */
    private $firstName;

    /**
     * @var LastName
     */
    private $lastName;

    public function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function __toString(): string
    {
        return $this->firstName.' '.$this->lastName;
    }
}
