<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\FileManager;

use App\Shared\Infrastructure\Generator\UuidGenerator;
use League\Flysystem\FilesystemWriter;

final class FileUploader
{
    public function __construct(
        private readonly FilesystemWriter $defaultStorage,
    ) {
    }


    public function __invoke(string $file, string $filename): string
    {
        $filename = \sprintf('%s-%s', UuidGenerator::generate(), $filename);

        $stream = \Safe\fopen($file, 'rb');

        $this->defaultStorage->writeStream($filename, $stream);

        \Safe\fclose($stream);

        return $filename;
    }
}
