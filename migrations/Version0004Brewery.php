<?php

declare(strict_types=1);

namespace BeeriouslyMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version0004Brewery extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE brewery (id VARCHAR(36) NOT NULL, name VARCHAR(250) NOT NULL, mass_volume_units VARCHAR(2) NOT NULL, density_units VARCHAR(5) NOT NULL, temperature_units VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN brewery.id IS \'(DC2Type:beeriously_brewery_id)\'');
        $this->addSql('COMMENT ON COLUMN brewery.name IS \'(DC2Type:beeriously_brewery_name)\'');
        $this->addSql('ALTER TABLE brewer ADD brewery_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN brewer.brewery_id IS \'(DC2Type:beeriously_brewery_id)\'');
        $this->addSql('ALTER TABLE brewer ADD CONSTRAINT FK_8C2B4A4BD15C960 FOREIGN KEY (brewery_id) REFERENCES brewery (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8C2B4A4BD15C960 ON brewer (brewery_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE brewer DROP CONSTRAINT FK_8C2B4A4BD15C960');
        $this->addSql('DROP TABLE brewery');
        $this->addSql('DROP INDEX IDX_8C2B4A4BD15C960');
        $this->addSql('ALTER TABLE brewer DROP brewery_id');
    }
}
