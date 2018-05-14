<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\SessionHandler;

use Doctrine\DBAL\Connection;

class DoctrineConnectionToPdoDsnAdapter implements PdoConnectionDsnProviderInterface
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getPdoDsn(): string
    {
        $driver = '';
        if ($this->connection->getDriver() instanceof \Doctrine\DBAL\Driver\PDOPgSql\Driver) {
            $driver = 'pgsql';
        } elseif ($this->connection->getDriver() instanceof \Doctrine\DBAL\Driver\Mysqli\Driver) {
            $driver = 'mysql';
        }

        return $driver.':host='.$this->connection->getHost().';port='.$this->connection->getPort().';dbname='.$this->connection->getDatabase();
    }

    public function getUsername(): string
    {
        return (string) $this->connection->getUsername();
    }

    public function getPassword(): string
    {
        return (string) $this->connection->getPassword();
    }
}
