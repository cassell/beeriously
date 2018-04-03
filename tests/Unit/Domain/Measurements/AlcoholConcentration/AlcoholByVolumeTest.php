<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\AlcoholConcentration;

use Beeriously\Domain\Measurements\AlcoholConcentration\AlcoholByVolume;
use Beeriously\Domain\Measurements\SpecificGravity\FinalGravity;
use Beeriously\Domain\Measurements\SpecificGravity\GravityRange;
use Beeriously\Domain\Measurements\SpecificGravity\OriginalGravity;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AlcoholByVolumeTest extends TestCase
{
    public function testFromGravityRange()
    {
        $ogArray = [
            '1.030' => ['0.990' => 5.2,
                    '0.995' => 4.55,
                    '1.00' => 3.9,
                    '1.005' => 3.25,
                    '1.010' => 2.6,
                    '1.015' => 1.95,
                    '1.020' => 1.3,
                    '1.025' => 0.65,
                    '1.030' => 0.0,
//                    "1.035" => \InvalidArgumentException::class,
//                    "1.040" => \InvalidArgumentException::class,
//                    "1.045" => \InvalidArgumentException::class,
//                    "1.050" => \InvalidArgumentException::class,
                ],
            '1.035' => ['0.990' => 5.85,
                    '0.995' => 5.21,
                    '1.00' => 4.56,
                    '1.005' => 3.91,
                    '1.010' => 3.26,
                    '1.015' => 2.61,
                    '1.020' => 1.96,
                    '1.025' => 1.31,
                    '1.030' => 0.65,
                    '1.035' => 0.0,
//                    "1.040" => \InvalidArgumentException::class,
//                    "1.045" => \InvalidArgumentException::class,
//                    "1.050" => \InvalidArgumentException::class,
                ],
        ];

        foreach ($ogArray as $og => $fgArray) {
            foreach ($fgArray as $fg => $abw) {
                $this->assertSame($abw, round(AlcoholByVolume::fromGravityRange(
                    new GravityRange(new OriginalGravity((float) $og), new FinalGravity((float) $fg)))->getValue(), 2));
            }
        }
    }
}
