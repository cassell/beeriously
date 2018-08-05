<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\Mass;

use Beeriously\Domain\Measurements\Mass\Kilograms;
use PHPUnit\Framework\TestCase;

class KilogramTest extends TestCase
{
    public function testGetter()
    {
        $this->assertEquals(1.0, (new Kilograms(1.0))->getValue());
    }
}
