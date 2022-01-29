<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Actions\CompanySymbols;

class CompanySymbolTest extends TestCase
{
    /** @test * */
    public function it_has_api_to_get_company_symbols()
    {
        $companies = (new CompanySymbols())->handle();

        $this->assertIsArray($companies);
        $this->assertNotEmpty($companies);
        foreach ($companies as $company) {
            $this->assertArrayHasKey('Symbol', $company);
        }
    }
}
