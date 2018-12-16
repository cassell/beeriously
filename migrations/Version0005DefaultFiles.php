<?php

declare(strict_types=1);

namespace BeeriouslyMigrations;

use Aws\S3\S3Client;
use Beeriously\Brewer\Brewer;
use Beeriously\Brewery\Brewery;
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
            'Bucket' => $this->getContainer()->getParameter('s3_bucket'),
            'Key' => Brewer::DEFAULT_PROFILE_PHOTO_KEY,
            'SourceFile' => __DIR__.'/../data/assets/default_user.png',
            'ACL' => 'public-read',
        ]);

        $s3Client->putObject([
            'Bucket' => $this->getContainer()->getParameter('s3_bucket'),
            'Key' => Brewery::DEFAULT_LOGO_PHOTO_KEY,
            'SourceFile' => __DIR__.'/../data/assets/beer-cup.png',
            'ACL' => 'public-read',
        ]);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
