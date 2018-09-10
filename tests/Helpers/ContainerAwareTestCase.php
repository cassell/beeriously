<?php

declare(strict_types=1);

namespace Beeriously\Tests\Helpers;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContainerAwareTestCase extends KernelTestCase
{
    protected function setUp()
    {
        self::bootKernel();
        $this->get('doctrine')->getConnection()->beginTransaction();
        parent::setUp();
    }

    protected function tearDown()
    {
        $this->get('doctrine')->getConnection()->rollback();
        parent::tearDown();
    }

    protected function get($class)
    {
        return static::$kernel->getContainer()->get($class);
    }

    protected function getParameter(string $name)
    {
        return static::$kernel->getContainer()->getParameter($name);
    }

    /**
     * @return ObjectManager
     */
    protected function getObjectManager(): ObjectManager
    {
        return $this->get('doctrine')->getManager();
    }
}
