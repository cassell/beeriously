<?php declare(strict_types = 1);

namespace BeeriouslyMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180406122439 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE organization (id VARCHAR(36) NOT NULL, name VARCHAR(250) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE brewer ADD organization_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE brewer ADD CONSTRAINT FK_8C2B4A4B32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8C2B4A4B32C8A3DE ON brewer (organization_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE brewer DROP CONSTRAINT FK_8C2B4A4B32C8A3DE');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP INDEX IDX_8C2B4A4B32C8A3DE');
        $this->addSql('ALTER TABLE brewer DROP organization_id');
    }
}
