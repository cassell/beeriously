<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery\Event;

use Beeriously\Brewery\Event\BreweryEventId;
use PHPUnit\Framework\TestCase;

class BreweryEventIdTest extends TestCase
{
    public function testToString()
    {
        $breweryEventId = BreweryEventId::fromString('AAA');
        $this->assertEquals('AAA', (string) $breweryEventId);
    }
}
