<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Support\Facades\App;
use App\Actions\CompanyHistoricalData;
use App\Actions\FilterCompanyHistoricalData;

class FilterCompanyHistoricDataTest extends TestCase
{
    /** @test * */
    public function it_can_filter_company_historic_data()
    {
        $inRangeData = [
            "date" => Carbon::now()->subDays(2)->unix(),
            "open" => 0.2,
            "high" => 0.2,
            "low" => 0.2,
            "close" => 0.2,
            "volume" => 177970,
        ];
        $this->mock(CompanyHistoricalData::class, function (MockInterface $mock) use ($inRangeData) {
            $mock->shouldReceive('handle')->once()->andReturn([
                'prices' => [
                    [
                        "date" => Carbon::now()->subDays(3)->unix(),
                        "open" => 0.3,
                        "high" => 0.3,
                        "low" => 0.2,
                        "close" => 0.2,
                        "volume" => 177970,
                    ],
                    $inRangeData,
                    [
                        "date" => Carbon::now()->addDays(2)->unix(),
                        "open" => 0.2,
                        "high" => 0.2,
                        "low" => 0.2,
                        "close" => 0.2,
                        "volume" => 177970,
                    ],
                ],
            ]);
        });
        $fromDate = Carbon::now()->subDays(2)->unix();
        $toDate = Carbon::now()->unix();

        $filteredData = App::call([new FilterCompanyHistoricalData('GOGG', $fromDate, $toDate), 'handle']);

        $this->assertIsArray($filteredData);
        $this->assertNotEmpty($filteredData);
        $this->assertEquals($inRangeData, array_values($filteredData)[0]);
        $this->assertEquals(1, count($filteredData));
    }
}
