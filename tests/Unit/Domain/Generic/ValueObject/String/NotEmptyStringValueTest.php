<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Generic\ValueObject\String;

use Beeriously\Universal\Identification\String\NotEmptyStringException;
use Beeriously\Universal\Identification\String\NotEmptyStringValue;
use PHPUnit\Framework\TestCase;

class NotEmptyStringValueTest extends TestCase
{
    public function testEmptyFails()
    {
        $this->expectException(NotEmptyStringException::class);
        new NotEmptyStringValue('');
    }

    public function testGetter()
    {
        $s = new NotEmptyStringValue('Beer!');
        $this->assertEquals('Beer!', $s->getValue());
    }

    public function testToString()
    {
        $s = new NotEmptyStringValue('Beer!');
        $this->assertEquals('Beer!', (string) $s);
    }
}
