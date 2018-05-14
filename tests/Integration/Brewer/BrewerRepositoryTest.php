<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewer;

use Beeriously\Brewer\Application\Brewer;
use Beeriously\Brewer\Infrastructure\DoctrineBrewerRepository;
use Beeriously\Tests\DataFixtures\TempBrewerFixture;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;

class BrewerRepositoryTest extends ContainerAwareTestCase
{
    protected function setUp()
    {
        parent::setUp();

        /** @var TempBrewerFixture $fixture */
        $fixture = $this->get(TempBrewerFixture::class);
        $fixture->load($this->getObjectManager());
    }

    public function testFindById()
    {
        $repo = $this->getRepository();
        $brewer = $repo->find(TempBrewerFixture::getBrewerId()->getValue());

        $this->assertInstanceOf(\Beeriously\Brewer\Domain\BrewerInterface::class, $brewer);
        $this->assertInstanceOf(Brewer::class, $brewer);
    }

    /**
     * @return DoctrineBrewerRepository
     */
    private function getRepository(): DoctrineBrewerRepository
    {
        /** @var DoctrineBrewerRepository $repo */
        $repo = $this->getObjectManager()->getRepository(Brewer::class);

        return $repo;
    }
}
