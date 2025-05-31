<?php

namespace App\Http\Controllers;

use App\Traits\Remote;

class DashboardController extends Controller
{
    use Remote;

    /**
     *  Display the dashboard with transaction reports.
     *  This method retrieves transaction reports based on the provided date range.
     *  @return \Illuminate\View\View
     * 
     */
    public function index()
    {
        $transaction_reports = $this->getTransactionReports(request()->get('from_date'), request()->get('to_date'));

        return view('dashboard', compact('transaction_reports'));
    }
}
