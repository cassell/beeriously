<?php

declare(strict_types=1);

namespace Beeriously\Domain\Brewers;

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

    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    public function getLastName(): LastName
    {
        return $this->lastName;
    }
}
