<?php

declare(strict_types=1);

namespace BeeriouslyMigrations;

use Aws\S3\S3Client;
use Beeriously\Brewer\Application\Brewer;
use Beeriously\Infrastructure\Migrations\ContainerAwareMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0005DefaultFiles extends ContainerAwareMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        /** @var S3Client $s3Client */
        $s3Client = $this->get(S3Client::class);

        $s3Client->putObject([
            'Bucket' => 'bucket',
            'Key' => Brewer::DEFAULT_PROFILE_PHOTO_KEY,
            'SourceFile' => __DIR__.'/../data/assets/default_user_200.png',
            'ACL' => 'public-read',
        ]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
