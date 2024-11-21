<?php

namespace App\Services\ProductApi;

use Doctrine\DBAL\Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductApi implements DataFetcherInterface
{

    protected string $url;

    protected HttpClientInterface $client;

    public function __construct(string $url, HttpClientInterface $client) {
        $this->url = $url;
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchData(): \stdClass
    {
        $response = $this->client->request('GET', $this->url);
        return json_decode($response->getContent());
    }
}