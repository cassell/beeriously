<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewer\Exception;

use Beeriously\Brewer\Domain\Exception\BrewerAccountAlreadyExistsException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class BrewerAccountAlreadyExistsExceptionTest extends TestCase
{
    public function test__construct()
    {
        $e = new BrewerAccountAlreadyExistsException($this->getMockUniqueConstraintViolationException());
        $this->assertSame('beeriously.brewer.exception.BrewerAccountAlreadyExistsException', $e->getMessage());
    }

    private function getMockUniqueConstraintViolationException()
    {
        $mock = $this->getMockBuilder(UniqueConstraintViolationException::class)->disableOriginalConstructor()->getMock();

        return $mock;
    }
}
