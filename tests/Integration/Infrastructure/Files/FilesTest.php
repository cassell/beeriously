<?php

declare(strict_types=1);

namespace Beeriously\Tests\Integration\Infrastructure\Files;

use Aws\S3\S3Client;
use Beeriously\Infrastructure\File\FileTransportToUploadStorageService;
use Beeriously\Infrastructure\File\FileTransportToUploadStorageServiceInterface;
use Beeriously\Tests\Helpers\ContainerAwareTestCase;

class FilesTest extends ContainerAwareTestCase
{
    public function testWriteToS3Bucket()
    {
        /** @var S3Client $s3Client */
        $s3Client = $this->get('test.'.S3Client::class);

        $s3Client->putObject([
            'Bucket' => 'bucket',
            'Key' => '/test/test-user-photo.png',
            'SourceFile' => __DIR__.'/../../../../data/assets/default_user.png',
            'ACL' => 'public-read',
        ]);

        $this->assertTrue($s3Client->doesObjectExist('bucket', '/test/test-user-photo.png'));

        $s3Client->deleteObject([
            'Bucket' => 'bucket',
            'Key' => '/test/test-user-photo.png',
        ]);
    }

    public function testWriteToFileTransport()
    {
        /** @var S3Client $s3Client */
        $s3Client = $this->get('test.'.S3Client::class);

        /** @var FileTransportToUploadStorageService $service */
        $service = $this->get('test.'.FileTransportToUploadStorageServiceInterface::class);

        $key = $service->transportToStorage(
            'user.png',
            'image/png',
            \file_get_contents(__DIR__.'/../../../../data/assets/default_user.png')
        );

        $this->assertStringMatchesFormat('uploads/%s/user.png', $key);

        $s3Client->deleteObject([
            'Bucket' => 'bucket',
            'Key' => $key,
        ]);
    }
}
