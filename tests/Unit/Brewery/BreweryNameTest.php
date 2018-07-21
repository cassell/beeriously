<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewery\Domain\BreweryName;
use Beeriously\Brewery\Domain\Exception\BreweryNameCanNotBeEmptyException;
use PHPUnit\Framework\TestCase;

class BreweryNameTest extends TestCase
{
    public function testEmptyFails()
    {
        $this->expectException(BreweryNameCanNotBeEmptyException::class);
        new BreweryName('');
    }

    public function testEquals()
    {
        $name = new BreweryName('Anheuser-Busch InBev');
        $this->assertTrue($name->equals(new BreweryName('Anheuser-Busch InBev')));
        $this->assertFalse($name->equals(new BreweryName('Sapporo Brewery')));
    }

    public function testValue()
    {
        $name = new BreweryName('Anheuser-Busch InBev');
        $this->assertSame('Anheuser-Busch InBev', (string) $name);
        $this->assertSame('Anheuser-Busch InBev', $name->getValue());
    }
}
