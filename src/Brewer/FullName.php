<?php

declare(strict_types=1);

namespace Beeriously\Brewer;

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

    public function serialize(): string
    {
        return json_encode(['first' => $this->firstName->getValue(), 'last' => $this->lastName->getValue()]);
    }

    public static function deserialize(string $json): self
    {
        $array = json_decode($json, true);

        return new self(
            new FirstName($array['first']),
            new LastName($array['last'])
        );
    }

    /**
     * @return FirstName
     */
    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    /**
     * @return LastName
     */
    public function getLastName(): LastName
    {
        return $this->lastName;
    }
}
