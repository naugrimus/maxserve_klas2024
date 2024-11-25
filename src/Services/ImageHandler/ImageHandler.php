<?php

namespace App\Services\ImageHandler;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Services\ImageHandler\imageHandlerInterface;
class ImageHandler implements \App\Services\ImageHandler\imageHandlerInterface
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
        return rtrim($this->imageDir, '/') . '/' . urldecode($filename);

    }

    protected function save(string $filename, string $content): void {
        $this->createDir($filename);
        file_put_contents($this->root . '/public/' . trim($this->imageDir, '/') . '/' . urldecode($filename), $content);
    }

    protected function getFileName($url): string {
        $filePath = parse_url($url)['path'];
        $parts = explode('/', $filePath);
        return $parts[count($parts) -2] . '/' . $parts[count($parts) - 1];
    }


    protected function createDir($filename) {
        $parts = explode('/', $filename);

        if(!is_dir($this->root . '/public/' . trim($this->imageDir , '/'))) {
            mkdir($this->root . '/public/' . trim($this->imageDir , '/'));
        }

        if(!is_dir($this->root . '/public/' . trim($this->imageDir , '/') . '/' . urldecode($parts[0]))) {
            mkdir($this->root . '/public/' . trim($this->imageDir, '/') . '/' . urldecode($parts[0]));
        }
    }
}