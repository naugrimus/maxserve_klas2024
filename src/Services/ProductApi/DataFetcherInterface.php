<?php

namespace App\Services\ProductApi;

interface DataFetcherInterface
{

    public function fetchData(string $url);
}