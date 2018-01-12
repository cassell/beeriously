<?php

declare(strict_types=1);

namespace Beeriously\Domain\Measurements\SpecificGravity;

class GravityRange
{
    /**
     * @var OriginalGravity
     */
    private $og;
    /**
     * @var FinalGravity
     */
    private $fg;

    public function __construct(OriginalGravity $og, FinalGravity $fg)
    {
        if ($fg->getValue() > $og->getValue()) {
            throw new \InvalidArgumentException('Final Gravity Must Be Less Than Original Gravity. '.$og->getValue().' - '.$fg->getValue());
        }
        $this->og = $og;
        $this->fg = $fg;
    }

    public function getOriginalGravity(): OriginalGravity
    {
        return $this->og;
    }

    public function getFinalGravity(): FinalGravity
    {
        return $this->fg;
    }
}
