<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Brewer;

use Beeriously\Brewer\Brewer;
use Beeriously\Brewer\Infrastructure\DoctrineBrewerRepository;
use Beeriously\Tests\DataFixtures\TestUserFixture;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;

class BrewerRepositoryTest extends ContainerAwareTestCase
{
    protected function setUp()
    {
        parent::setUp();

        /** @var TestUserFixture $fixture */
        $fixture = $this->get(TestUserFixture::class);
        $fixture->load($this->getObjectManager());
    }

    public function testFindById()
    {
        $repo = $this->getRepository();
        $brewer = $repo->find(TestUserFixture::getBrewerId()->getValue());

        $this->assertInstanceOf(\Beeriously\Brewer\BrewerInterface::class, $brewer);
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
