<?php

declare(strict_types=1);

namespace BeeriouslyMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version0002 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE `brewer` ADD `first_name` VARCHAR(100)  NULL  DEFAULT NULL  AFTER `roles`;');
        $this->addSql('ALTER TABLE `brewer` ADD `last_name` VARCHAR(100)  NULL  DEFAULT NULL  AFTER `first_name`;');
        $this->addSql('ALTER TABLE `brewer` ADD `units_of_measurement` VARCHAR(2)  NULL  DEFAULT NULL  AFTER `last_name`;');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE `brewer` DROP `first_name`;');
        $this->addSql('ALTER TABLE `brewer` DROP `last_name`;');
        $this->addSql('ALTER TABLE `brewer` DROP `units_of_measurement`;');
    }
}
