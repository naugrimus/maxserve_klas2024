<?php

namespace App\Services\ImageHandler;

interface imageHandlerInterface
{
    public function download(string $url): string;
}