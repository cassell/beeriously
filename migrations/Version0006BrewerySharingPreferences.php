<?php

declare(strict_types=1);

namespace BeeriouslyMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0006BrewerySharingPreferences extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE brewery ADD preferences JSON NOT NULL');
        $this->addSql('COMMENT ON COLUMN brewery.preferences IS \'(DC2Type:beeriously_brewery_sharing_preferences)\'');
        $this->addSql('ALTER TABLE brewer ALTER profile_photo_key DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE brewery DROP preferences');
        $this->addSql('ALTER TABLE brewer ALTER profile_photo_key SET NOT NULL');
    }
}
