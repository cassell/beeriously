<?php

declare(strict_types=1);

namespace BeeriouslyMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version0002BrewerProfile extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE `brewer` ADD `first_name` VARCHAR(100) NOT NULL AFTER `roles`;');
        $this->addSql('ALTER TABLE `brewer` ADD `last_name` VARCHAR(100) NOT NULL AFTER `first_name`;');
        $this->addSql('ALTER TABLE `brewer` ADD `mass_volume_units` VARCHAR(2) NOT NULL AFTER `last_name`;');
        $this->addSql('ALTER TABLE `brewer` ADD `density_units` VARCHAR(5) NOT NULL AFTER `last_name`;');
        $this->addSql('ALTER TABLE `brewer` ADD `temperature_units` VARCHAR(1) NOT NULL AFTER `last_name`;');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `brewer` DROP `first_name`;');
        $this->addSql('ALTER TABLE `brewer` DROP `last_name`;');
        $this->addSql('ALTER TABLE `brewer` DROP `mass_volume_units`;');
        $this->addSql('ALTER TABLE `brewer` DROP `density_units`;');
        $this->addSql('ALTER TABLE `brewer` DROP `temperature_units`;');
    }
}
