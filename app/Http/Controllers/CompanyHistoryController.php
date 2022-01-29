<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Actions\CompanySymbols;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use App\Mail\HistoricalDataRequestedMail;
use App\Actions\FilterCompanyHistoricalData;

class CompanyHistoryController extends Controller
{
    /**
     * @var CompanySymbols
     */
    private $companySymbols;

    /**
     * CompanyHistoryController constructor.
     * @param  CompanySymbols  $companySymbols
     */
    public function __construct(CompanySymbols $companySymbols)
    {
        $this->companySymbols = $companySymbols;
    }

    public function create(Request $request): View
    {
        $companies = $this->companySymbols->handle();
        $data = array_column($companies, 'Company Name', 'Symbol');

        return view('company-history.create', compact('data'));
    }

    public function store(Request $request): mixed
    {
        $companies = $this->companySymbols->handle();
        $companySymbols = array_column($companies, 'Symbol');

        $request->validate([
            'symbol' => [
                'required',
                Rule::in($companySymbols),
            ],
            'from_date' => 'required|date_format:Y-m-d|before_or_equal:today',
            'to_date' => 'required|date_format:Y-m-d|before_or_equal:today|after_or_equal:from_date',
            'email' => 'required|email',
        ]);

        $fromDate = Carbon::createFromFormat('Y-m-d', $request->from_date)->unix();
        $toDate = Carbon::createFromFormat('Y-m-d', $request->to_date)->unix();
        $companyData = App::call([new FilterCompanyHistoricalData($request->symbol, $fromDate, $toDate), 'handle']);
        if (!$companyData) {
            request()->session()->flash('status-error', 'No data available!');

            return redirect()->back();
        }
        $selectedCompany = array_values(array_filter($companies, function ($company) {
            return $company['Symbol'] == request('symbol');
        }))[0];
        Mail::to($request->email)
            ->queue(new HistoricalDataRequestedMail(
                $selectedCompany['Company Name'],
                $request->from_date,
                $request->to_date
            ));

        return view('company-history.store', compact('companyData', 'selectedCompany'));
    }
}
