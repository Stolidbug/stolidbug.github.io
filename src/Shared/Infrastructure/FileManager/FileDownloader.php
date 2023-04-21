<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\FileManager;

use League\Flysystem\FilesystemReader;

final class FileDownloader implements FileDownloaderInterface
{
    public function __construct(
        private readonly FilesystemReader $defaultStorage,
    ) {
    }

    public function __invoke(string $encodedFilename): File
    {
        return new File(
            $this->defaultStorage->readStream($encodedFilename),
            $this->defaultStorage->mimeType($encodedFilename),
        );
    }
}
