<?php

namespace App\Actions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CompanySymbols
{
    /**
     * Get company symbols from api
     * @return array
     */
    public function handle(): array
    {
        try {
            $client = new Client();
            $response = $client->request('GET',
                'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json',
                [
                    'headers' => [
                        'Accept' => 'application/json',
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
