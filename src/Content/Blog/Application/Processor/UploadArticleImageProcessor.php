<?php

declare(strict_types=1);

namespace App\Content\Blog\Application\Processor;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Shared\Infrastructure\FileManager\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class UploadArticleImageProcessor
{
    public function __construct(
        private readonly FileUploader $fileUploader,
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

        $imageFilename = ($this->fileUploader)(
            $uploadedFile->getRealPath(),
            $uploadedFile->getClientOriginalName()
        );

        $article->setImage($imageFilename);
    }
}
