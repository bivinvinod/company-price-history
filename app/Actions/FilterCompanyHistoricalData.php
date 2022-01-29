<?php

namespace App\Actions;

class FilterCompanyHistoricalData
{
    public $toDate;
    public $companySymbol;
    public $fromDate;

    /**
     * FilterCompanyHistoricalData constructor.
     * @param  string  $companySymbol
     * @param  string  $fromDate
     * @param  string  $toDate
     */
    public function __construct($companySymbol, $fromDate, $toDate)
    {
        $this->toDate = $toDate;
        $this->companySymbol = $companySymbol;
        $this->fromDate = $fromDate;
    }

    /**
     * Filter company data using date range
     * @param  CompanyHistoricalData  $companyHistoricalData
     * @return array
     */
    public function handle(CompanyHistoricalData $companyHistoricalData): array
    {
        $companyData = $companyHistoricalData->handle($this->companySymbol);
        if (!$companyData || !$companyData['prices']) {
            return [];
        }

        $filteredData = array_filter($companyData['prices'], function ($data) {
            return ($data['date'] >= $this->fromDate && $data['date'] <= $this->toDate) && (!empty($data['open']) || !empty($data['close']));
        });
        if (!$filteredData) {
            return [];
        }
        usort($filteredData, function ($first, $second) {
            return $first['date'] <=> $second['date'];
        });

        return $filteredData;
    }
}
