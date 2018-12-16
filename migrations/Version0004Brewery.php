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
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE brewery (id VARCHAR(36) NOT NULL, name VARCHAR(250) NOT NULL, sharing_settings JSON NOT NULL, measurement_settings JSON NOT NULL, logo_photo_key VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN brewery.id IS \'(DC2Type:beeriously_brewery_id)\'');
        $this->addSql('COMMENT ON COLUMN brewery.name IS \'(DC2Type:beeriously_brewery_name)\'');
        $this->addSql('COMMENT ON COLUMN brewery.sharing_settings IS \'(DC2Type:beeriously_brewery_sharing_settings)\'');
        $this->addSql('COMMENT ON COLUMN brewery.measurement_settings IS \'(DC2Type:beeriously_brewery_measurement_settings)\'');
        $this->addSql('COMMENT ON COLUMN brewery.logo_photo_key IS \'(DC2Type:beeriously_storage_key)\'');
        $this->addSql('CREATE TABLE brewery_event_link (brewery_id VARCHAR(36) NOT NULL, event_id VARCHAR(36) NOT NULL, PRIMARY KEY(brewery_id, event_id))');
        $this->addSql('CREATE INDEX IDX_A157B02DD15C960 ON brewery_event_link (brewery_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A157B02D71F7E88B ON brewery_event_link (event_id)');
        $this->addSql('COMMENT ON COLUMN brewery_event_link.brewery_id IS \'(DC2Type:beeriously_brewery_id)\'');
        $this->addSql('COMMENT ON COLUMN brewery_event_link.event_id IS \'(DC2Type:beeriously_brewery_event_id)\'');
        $this->addSql('CREATE TABLE brewery_event (id VARCHAR(36) NOT NULL, data JSON NOT NULL, occurred_on TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_by_id VARCHAR(36) NOT NULL, created_by_full_name VARCHAR(1000) NOT NULL, brewery_id VARCHAR(36) NOT NULL, event VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN brewery_event.id IS \'(DC2Type:beeriously_brewery_event_id)\'');
        $this->addSql('COMMENT ON COLUMN brewery_event.data IS \'(DC2Type:json_array)\'');
        $this->addSql('COMMENT ON COLUMN brewery_event.occurred_on IS \'(DC2Type:beeriously_occurred_on)\'');
        $this->addSql('COMMENT ON COLUMN brewery_event.created_by_id IS \'(DC2Type:beeriously_brewer_id)\'');
        $this->addSql('COMMENT ON COLUMN brewery_event.created_by_full_name IS \'(DC2Type:beeriously_brewer_full_name)\'');
        $this->addSql('COMMENT ON COLUMN brewery_event.brewery_id IS \'(DC2Type:beeriously_brewery_id)\'');
        $this->addSql('ALTER TABLE brewery_event_link ADD CONSTRAINT FK_A157B02DD15C960 FOREIGN KEY (brewery_id) REFERENCES brewery (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brewery_event_link ADD CONSTRAINT FK_A157B02D71F7E88B FOREIGN KEY (event_id) REFERENCES brewery_event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brewer ADD brewery_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE brewer ALTER profile_photo_key TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE brewer ALTER profile_photo_key DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN brewer.brewery_id IS \'(DC2Type:beeriously_brewery_id)\'');
        $this->addSql('ALTER TABLE brewer ADD CONSTRAINT FK_8C2B4A4BD15C960 FOREIGN KEY (brewery_id) REFERENCES brewery (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8C2B4A4BD15C960 ON brewer (brewery_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE brewery_event_link DROP CONSTRAINT FK_A157B02DD15C960');
        $this->addSql('ALTER TABLE brewer DROP CONSTRAINT FK_8C2B4A4BD15C960');
        $this->addSql('ALTER TABLE brewery_event_link DROP CONSTRAINT FK_A157B02D71F7E88B');
        $this->addSql('DROP TABLE brewery');
        $this->addSql('DROP TABLE brewery_event_link');
        $this->addSql('DROP TABLE brewery_event');
        $this->addSql('DROP INDEX IDX_8C2B4A4BD15C960');
        $this->addSql('ALTER TABLE brewer DROP brewery_id');
        $this->addSql('ALTER TABLE brewer ALTER profile_photo_key TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE brewer ALTER profile_photo_key DROP DEFAULT');
    }
}
