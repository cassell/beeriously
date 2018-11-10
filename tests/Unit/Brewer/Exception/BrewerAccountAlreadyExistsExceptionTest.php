<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewer\Exception;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class BrewerAccountAlreadyExistsExceptionTest extends TestCase
{
    public function test__construct()
    {
        $e = new \Beeriously\Brewer\Exception\BrewerAccountAlreadyExistsException($this->getMockUniqueConstraintViolationException());
        $this->assertEquals('beeriously.brewer.exception.BrewerAccountAlreadyExistsException', $e->getMessage());
    }

    private function getMockUniqueConstraintViolationException()
    {
        $mock = $this->getMockBuilder(UniqueConstraintViolationException::class)->disableOriginalConstructor()->getMock();

        return $mock;
    }
}
