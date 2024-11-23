<?php

namespace App\Services;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImageHandler
{

    protected string $root;

    protected HttpClientInterface $client;
    protected string $imageDir;

    public function __construct(string $root, string $imageDir, HttpClientInterface $client) {
        $this->root = $root;
        $this->imageDir = trim($imageDir);
        $this->client = $client;

    }

    public function download(string $url): string {
        $file = $this->client->request('GET', $url);
        $filename = $this->getFileName($url);
        $this->save($filename, $file->getContent());
        return $this->imageDir . '/' . $filename;

    }

    public function save(string $filename, string $content): void {
        $this->createDir();
        file_put_contents($this->root . '/' . $this->imageDir . '/' . $filename, $content);
    }

    protected function getFileName($url): string {
        $filePath = parse_url($url)['path'];
        $parts = explode('/', $filePath);
        return $this->getDefinedFileName($parts);
    }

    protected function getDefinedFileName(array $fileParts): string {
        $name = $fileParts[count($fileParts) -1];
        if(strtolower($name) == 'thumbnail.png') {
            return $fileParts[count($fileParts) -2] . 'thumbnail.png';
        }
        return $name;
    }

    protected function createDir() {
        if(!is_dir($this->root . '/' . $this->imageDir)) {
            mkdir($this->root . '/' . $this->imageDir);
        }
    }
}