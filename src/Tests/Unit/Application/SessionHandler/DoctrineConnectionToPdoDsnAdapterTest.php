<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Application\SessionHandler;

use Beeriously\Application\SessionHandler\DoctrineConnectionToPdoDsnAdapter;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DoctrineConnectionToPdoDsnAdapterTest extends TestCase
{
    public function testGetUsername()
    {
        $adapter = new DoctrineConnectionToPdoDsnAdapter($this->getConnectionMock());
        $this->assertSame('username', $adapter->getUsername());
    }

    public function testGetPassword()
    {
        $adapter = new DoctrineConnectionToPdoDsnAdapter($this->getConnectionMock());
        $this->assertSame('password', $adapter->getPassword());
    }

    public function testGetDsn()
    {
        $adapter = new DoctrineConnectionToPdoDsnAdapter($this->getConnectionMock());
        $this->assertSame('mysql:host=host_name;port=port_number;dbname=database_name', $adapter->getPdoDsn());
    }

    /**
     * @return Connection|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getConnectionMock()
    {
        $mock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $mock->method('getUsername')->willReturn('username');
        $mock->method('getPassword')->willReturn('password');
        $mock->method('getHost')->willReturn('host_name');
        $mock->method('getPort')->willReturn('port_number');
        $mock->method('getDatabase')->willReturn('database_name');

        return $mock;
    }
}
