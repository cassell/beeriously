<?php

declare(strict_types=1);

namespace Beeriously\Application\SessionHandler;

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
        return 'mysql:host='.$this->connection->getHost().';port='.$this->connection->getPort().';dbname='.$this->connection->getDatabase();
    }

    public function getUsername(): string
    {
        return $this->connection->getUsername();
    }

    public function getPassword(): string
    {
        return $this->connection->getPassword();
    }
}
