<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Domain\Organization;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Domain\Organization\Organization;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

class OrganizationTest extends TestCase
{
    public function testFromBrewer()
    {
        $brewer = new Brewer();
        $brewer->setFirstName('Søren');
        $brewer->setLastName('Sørensen');
        $organization = Organization::fromBrewer($brewer, $this->getMockTranslator());
        $this->assertSame('Søren Sørensen\'s Brewery', $organization->getName()->getValue());
    }

    private function getMockTranslator()
    {
        $mock = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $mock->method('trans')->willReturn('Søren Sørensen\'s Brewery');

        return $mock;
    }
}
