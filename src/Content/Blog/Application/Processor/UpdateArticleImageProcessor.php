<?php

declare(strict_types=1);

namespace App\Content\Blog\Application\Processor;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Shared\Infrastructure\FileManager\FileUploader;
use League\Flysystem\FilesystemWriter;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class UpdateArticleImageProcessor
{
    public function __construct(
        private readonly FileUploader $fileUploader,
        private readonly FilesystemWriter $defaultStorage,
    ) {
    }

    public function process(Article $article, Request $request): void
    {
        $articleFiles = $request->files->get('article');
        if (!is_array($articleFiles) || !isset($articleFiles['image'])) {
            return;
        }

        $uploadedFile = $articleFiles['image'];
        if (!($uploadedFile instanceof UploadedFile)) {
            return;
        }

        $oldImage = $article->getImage();

        if ($oldImage) {
            $this->defaultStorage->delete($oldImage);
        }

        $imageFilename = ($this->fileUploader)($uploadedFile->getRealPath(), $uploadedFile->getClientOriginalName());

        $article->setImage($imageFilename);
    }
}
