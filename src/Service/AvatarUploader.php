<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Service for upload avatars
 */
final class AvatarUploader
{
    public function __construct(private SluggerInterface $slugger, private string $avatarsDirectory)
    {
    }

    /**
     * Return the absolute path of the directory where avatars files are stored.
     *
     * @return string
     */
    public function getAvatarsDirectory(): string
    {
        return $this->avatarsDirectory;
    }

    /**
     * @return string[]
     */
    public function getAuthorizedMimeTypes(): array
    {
        return ["image/jpeg", "image/png"];
    }

    /**
     * @return integer
     */
    public function getMaxFileSize(): int
    {
        return 2000000; // 2MB (1.907349 MiB)
    }

    /**
     * Upload an avatar
     *
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = $this->slugger->slug($originalFilename) . "-" . uniqid() . "." . $file->guessExtension();
        $file->move($this->getAvatarsDirectory(), $filename);
        return $filename;
    }
}
