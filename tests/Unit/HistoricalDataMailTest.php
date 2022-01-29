<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use App\Mail\HistoricalDataRequestedMail;

class HistoricalDataMailTest extends TestCase
{
    /** @test * */
    public function it_has_company_price_history_email()
    {
        $fromDate = Carbon::now()->subDays(2)->format('Y-m-d');
        $toDate = Carbon::now()->format('Y-m-d');

        $mailable = new HistoricalDataRequestedMail('GOOG', $fromDate, $toDate);

        $mailable->assertSeeInHtml($fromDate);
        $mailable->assertSeeInHtml($toDate);
    }
}
