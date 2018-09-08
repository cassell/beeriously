<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\File;

use Ramsey\Uuid\Uuid;

class FileTransportToUploadStorageService implements FileTransportToUploadStorageServiceInterface
{
    /**
     * @var \Aws\S3\S3Client
     */
    private $s3Client;
    private $bucket;
    private $acl;
    private $cacheControl;

    public function __construct(\Aws\S3\S3Client $s3Client, $bucket, $acl, $cacheControl)
    {
        $this->s3Client = $s3Client;
        $this->bucket = $bucket;
        $this->acl = $acl;
        $this->cacheControl = $cacheControl;
    }

    public function transportToStorage(string $filename, string $contentType, string $contents)
    {
        $key = 'uploads/'.Uuid::uuid4()->toString().'/'.$filename;

        $this->s3Client->putObject([
            'Bucket' => $this->bucket,
            'Key' => $key,
            'Body' => $contents,
            'ACL' => 'public-read',
            'ContentType' => $contentType,
            'CacheControl' => $this->cacheControl,
        ]);

        return $key;
    }
}
