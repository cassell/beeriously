<?php

declare(strict_types=1);

namespace Beeriouslymigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version0002BrewerProfile extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE brewer ADD first_name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE brewer ADD last_name VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE brewer DROP first_name');
        $this->addSql('ALTER TABLE brewer DROP last_name');
    }
}
