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
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
