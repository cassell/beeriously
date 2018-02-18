<?php

declare(strict_types=1);

namespace BeeriouslyMigrations;

use Beeriously\Application\Migrations\ContainerAwareMigration;
use Beeriously\Application\SessionHandler\SessionHandler;
use Doctrine\DBAL\Migrations\Version;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version0003PdoSessionStorage extends ContainerAwareMigration
{
    public function __construct(Version $version)
    {
        parent::__construct($version);
    }

    public function up(Schema $schema)
    {
        $this->get(SessionHandler::class)->createTable();
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
