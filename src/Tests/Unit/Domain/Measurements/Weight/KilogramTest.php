<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Measurements\Weight;

use Beeriously\Domain\Measurements\Weight\Kilograms;
use PHPUnit\Framework\TestCase;

class KilogramTest extends TestCase
{
    public function testGetter()
    {
        $this->assertSame(1.0, (new Kilograms(1.0))->getValue());
    }
}
