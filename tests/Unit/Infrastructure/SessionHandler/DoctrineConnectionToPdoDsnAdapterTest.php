<?php

declare(strict_types=1);

namespace Beeriously\Tests\Unit\Infrastructure\SessionHandler;

use Beeriously\Infrastructure\SessionHandler\DoctrineConnectionToPdoDsnAdapter;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class DoctrineConnectionToPdoDsnAdapterTest extends TestCase
{
    public function testGetUsername()
    {
        $adapter = new DoctrineConnectionToPdoDsnAdapter($this->getMysqlConnectionMock());
        $this->assertSame('username', $adapter->getUsername());
    }

    public function testGetPassword()
    {
        $adapter = new DoctrineConnectionToPdoDsnAdapter($this->getMysqlConnectionMock());
        $this->assertSame('password', $adapter->getPassword());
    }

    public function testGetDsn()
    {
        $adapter = new \Beeriously\Infrastructure\SessionHandler\DoctrineConnectionToPdoDsnAdapter($this->getMysqlConnectionMock());
        $this->assertSame('mysql:host=host_name;port=port_number;dbname=database_name', $adapter->getPdoDsn());
    }

    public function testPostgresGetDsn()
    {
        $adapter = new \Beeriously\Infrastructure\SessionHandler\DoctrineConnectionToPdoDsnAdapter($this->getPostgresConnectionMock());
        $this->assertSame('pgsql:host=host_name;port=port_number;dbname=database_name', $adapter->getPdoDsn());
    }

    private function getMysqlConnectionMock()
    {
        $mysqlDriverMock = $this->getMockBuilder(\Doctrine\DBAL\Driver\Mysqli\Driver::class)->disableOriginalConstructor()->getMock();

        $mock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $mock->method('getDriver')->willReturn($mysqlDriverMock);
        $mock->method('getUsername')->willReturn('username');
        $mock->method('getPassword')->willReturn('password');
        $mock->method('getHost')->willReturn('host_name');
        $mock->method('getPort')->willReturn('port_number');
        $mock->method('getDatabase')->willReturn('database_name');

        return $mock;
    }

    private function getPostgresConnectionMock()
    {
        $mysqlDriverMock = $this->getMockBuilder(\Doctrine\DBAL\Driver\PDOPgSql\Driver::class)->disableOriginalConstructor()->getMock();

        $mock = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock();
        $mock->method('getDriver')->willReturn($mysqlDriverMock);
        $mock->method('getUsername')->willReturn('username');
        $mock->method('getPassword')->willReturn('password');
        $mock->method('getHost')->willReturn('host_name');
        $mock->method('getPort')->willReturn('port_number');
        $mock->method('getDatabase')->willReturn('database_name');

        return $mock;
    }
}
