<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Generic\ValueObject\String;

use Beeriously\Universal\Identification\String\StringValue;
use PHPUnit\Framework\TestCase;

class StringValueTest extends TestCase
{
    public function testEmpty()
    {
        $s = new StringValue();
        $this->assertEquals('', $s->getValue());

        $s = new \Beeriously\Universal\Identification\String\StringValue(null);
        $this->assertEquals('', $s->getValue());

        $s = new StringValue('');
        $this->assertEquals('', $s->getValue());
    }

    public function testValue()
    {
        $s = new StringValue('Beeriously');
        $this->assertEquals('Beeriously', $s->getValue());
    }

    public function testToString()
    {
        $s = new StringValue('Beeriously');
        $this->assertEquals('Beeriously', (string) $s);
    }
}
