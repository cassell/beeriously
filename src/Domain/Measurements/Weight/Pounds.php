<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\Weight;

class Pounds
{
    const POUNDS_PER_KILOGRAM = 0.45359237;

    /**
     * @var float
     */
    private $value;

    public function __construct(float $value)
    {
        if ($value === -0) {
            $value = 0;
        }

        if ($value < 0) {
            throw new \InvalidArgumentException('Weight may not be negative');
        }

        $this->value = $value;
    }

    public function reduceBy(self $pounds): self
    {
        return new self($this->value - $pounds->getValue());
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    public static function fromKilograms(Kilograms $kilogram): self
    {
        return new self(self::POUNDS_PER_KILOGRAM * $kilogram->getValue());
    }
}
