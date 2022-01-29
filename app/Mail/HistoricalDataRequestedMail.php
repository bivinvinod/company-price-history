<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HistoricalDataRequestedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $fromDate;
    protected $toDate;
    /**
     * @var string
     */
    protected $companyName;

    /**
     * Create a new message instance.
     *
     * @param  string  $companyName
     * @param  string  $fromDate
     * @param  string  $toDate
     */
    public function __construct($companyName, $fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->companyName = $companyName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->companyName)
            ->markdown('emails.company.history', [
                'fromDate' => $this->fromDate,
                'toDate' => $this->toDate,
            ]);
    }
}
