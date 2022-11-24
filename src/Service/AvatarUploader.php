<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

final class AvatarUploader
{
    public function __construct(private SluggerInterface $slugger, private string $avatarsDirectory)
    {
    }

    public function getAvatarsDirectory(): string
    {
        return $this->avatarsDirectory;
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = $this->slugger->slug($originalFilename) . "-" . uniqid() . "." . $file->guessExtension();
        $file->move($this->getAvatarsDirectory(), $filename);
        return $filename;
    }
}
