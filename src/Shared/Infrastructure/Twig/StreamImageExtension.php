<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Twig;

use App\Content\Blog\Shared\Infrastructure\Persistence\Doctrine\ORM\Entity\Article;
use App\Shared\Infrastructure\FileManager\FileDownloader;
use Symfony\Component\Asset\Packages;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class StreamImageExtension extends AbstractExtension
{
    private FileDownloader $fileDownloader;

    private Packages $packages;

    public function __construct(
        FileDownloader $fileDownloader,
        Packages $packages,
    ) {
        $this->fileDownloader = $fileDownloader;
        $this->packages = $packages;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('stream_image', [$this, 'streamImage']),
            new TwigFunction('stream_image_string', [$this, 'streamImageString']),
        ];
    }

    public function streamImage(Article $article): string
    {
        if (null === $article->getImage()) {
            return $this->packages->getUrl('/assets/frontend/images/blog/articles/default.png');
        }

        $image = ($this->fileDownloader)($article->getImage());

        if (!is_resource($image->getStream())) {
            return '';
        }

        $contents = stream_get_contents($image->getStream());

        if (false === $contents) {
            return '';
        }

        $base64 = base64_encode($contents);

        return 'data:image/jpeg;base64,' . $base64;
    }

    public function streamImageString(string $image): string
    {
        if ('' === $image) {
            return $this->packages->getUrl('/assets/frontend/images/blog/articles/default.png');
        }

        $image = ($this->fileDownloader)($image);

        if (!is_resource($image->getStream())) {
            return '';
        }

        $contents = stream_get_contents($image->getStream());

        if (false === $contents) {
            return '';
        }

        $base64 = base64_encode($contents);

        return 'data:image/jpeg;base64,' . $base64;
    }
}
