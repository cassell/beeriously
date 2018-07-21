<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewer;

use Beeriously\Brewer\Domain\Brewers;
use PHPUnit\Framework\TestCase;

class BrewersTest extends TestCase
{
    public function testGetBrewerId()
    {
        $this->expectException(\RuntimeException::class);
        new Brewers([]);
    }
}
