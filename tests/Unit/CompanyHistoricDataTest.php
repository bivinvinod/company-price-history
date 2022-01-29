<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Actions\CompanySymbols;
use App\Actions\CompanyHistoricalData;

class CompanyHistoricDataTest extends TestCase
{
    /** @test * */
    public function it_has_api_for_getting_historic_data_of_a_company()
    {
        $companies = (new CompanySymbols())->handle();

        $historicData = (new CompanyHistoricalData())->handle($companies[0]['Symbol']);

        $this->assertIsArray($historicData);
        $this->assertNotEmpty($historicData);
        $this->assertNotEmpty($historicData['prices']);
        foreach ($historicData['prices'] as $price) {
            $this->assertArrayHasKey('date', $price);
            $this->assertArrayHasKey('open', $price);
            $this->assertArrayHasKey('high', $price);
            $this->assertArrayHasKey('low', $price);
            $this->assertArrayHasKey('close', $price);
            $this->assertArrayHasKey('volume', $price);
        }
    }
}
