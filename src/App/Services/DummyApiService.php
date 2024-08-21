<?php

namespace Console\App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DummyApiService extends Client
{
    private const DEFAULT_PARAMS = [
        'limit' => '30'
    ];

    public function __construct(string $baseUrl)
    {
        parent::__construct([
            'base_uri' => $baseUrl,
        ]);
    }

    public function load(string $endpoint = '', array $params = []): array
    {
        try {
            $response = $this->get($endpoint, [
                'query' => array_merge(self::DEFAULT_PARAMS, $params)
            ]);

            return json_decode($response->getBody()->getContents(),true);
        } catch (GuzzleException $e) {
            exit($e->getMessage() . "\n");
        }
    }
}