<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Brewery;

use Beeriously\Brewer\FirstName;
use Beeriously\Brewer\FullName;
use Beeriously\Brewer\LastName;
use Beeriously\Brewery\Application\Name\BreweryNameFactory;
use Beeriously\Brewery\Domain\BreweryName;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\TranslatorInterface;

class BreweryNameFactoryTest extends TestCase
{
    public function testCreate()
    {
        $f = new BreweryNameFactory($this->getMockTranslator());
        $this->assertEquals(new BreweryName('Søren Sørensen\'s Brewery'), $f->fromBrewerName(new FullName(new FirstName('Søren'), new LastName('Sørensen'))));
    }

    private function getMockTranslator()
    {
        $mock = $this->getMockBuilder(TranslatorInterface::class)->getMock();
        $mock->method('trans')->willReturn('Søren Sørensen\'s Brewery');

        /* @var TranslatorInterface $mock */
        return $mock;
    }
}
