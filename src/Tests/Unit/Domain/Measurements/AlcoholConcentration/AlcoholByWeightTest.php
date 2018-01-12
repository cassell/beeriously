<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\AlcoholConcentration;

use Beeriously\Domain\Measurements\AlcoholConcentration\AlcoholByWeight;
use Beeriously\Domain\Measurements\SpecificGravity\FinalGravity;
use Beeriously\Domain\Measurements\SpecificGravity\GravityRange;
use Beeriously\Domain\Measurements\SpecificGravity\OriginalGravity;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AlcoholByWeightTest extends TestCase
{
    public function testFromGravityRange()
    {
        $ogArray = [
            '1.030' => ['0.990' => 4.17,
                    '0.995' => 3.63,
                    '1.00' => 3.10,
                    '1.005' => 2.57,
                    '1.010' => 2.05,
                    '1.015' => 1.53,
                    '1.020' => 1.01,
                    '1.025' => 0.51,
                    '1.030' => 0.0,
//                    "1.035" => \InvalidArgumentException::class,
//                    "1.040" => \InvalidArgumentException::class,
//                    "1.045" => \InvalidArgumentException::class,
//                    "1.050" => \InvalidArgumentException::class,
                ],
            '1.035' => ['0.990' => 4.69,
                    '0.995' => 4.15,
                    '1.00' => 3.62,
                    '1.005' => 3.09,
                    '1.010' => 2.56,
                    '1.015' => 2.04,
                    '1.020' => 1.52,
                    '1.025' => 1.01,
                    '1.030' => 0.5,
                    '1.035' => 0.0,
//                    "1.040" => \InvalidArgumentException::class,
//                    "1.045" => \InvalidArgumentException::class,
//                    "1.050" => \InvalidArgumentException::class,
                ],
        ];

        foreach ($ogArray as $og => $fgArray) {
            foreach ($fgArray as $fg => $abw) {
                $this->assertSame($abw, round(AlcoholByWeight::fromGravityRange(
                    new GravityRange(new OriginalGravity((float) $og), new FinalGravity((float) $fg)))->getValue(), 2));
            }
        }
    }
}
