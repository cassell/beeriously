<?php

declare(strict_types=1);

namespace Beeriously\Infrastructure\File;

interface FileTransportToUploadStorageServiceInterface
{
    public function transportToStorage(string $filename, string $contentType, string $contents);
}
