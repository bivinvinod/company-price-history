<?php

namespace App\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CompanyHistoricalData
{
    /*
     * @var string Rapid api key
     */
    private $apiKey;

    /**
     * CompanyHistoricalData constructor.
     */
    public function __construct()
    {
        $this->apiKey = config('services.rapid_api.key');
    }

    /**
     * Get Historic data of the symbol
     * @param  string  $companySymbol
     * @return array
     */
    public function handle($companySymbol): array
    {
        try {
            $client = new Client();
            $response = $client->request('GET',
                'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data',
                [
                    'query' => ['symbol' => $companySymbol],
                    'headers' => [
                        'Accept' => 'application/json',
                        'x-rapidapi-host' => 'yh-finance.p.rapidapi.com',
                        'x-rapidapi-key' => $this->apiKey,
                    ],
                    'timeout' => 3.14,
                    'verify' => false,
                ]);

            return json_decode($response->getBody(), true) ?? [];
        } catch (GuzzleException $e) {
            return [];
        }
    }
}
