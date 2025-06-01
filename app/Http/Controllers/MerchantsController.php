<?php

namespace App\Http\Controllers;

use App\Traits\Remote;

class MerchantsController extends Controller
{
    use Remote;

    /**
     * Display the specified merchant.
     *
     * @param  $transaction_id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($transaction_id)
    {
        $merchant = $this->getMerchant($transaction_id);

        if (! $merchant->customerInfo) {
            return redirect()->route('transactions.index')->with('error', 'Merchant not found.');
        }

        return view('partials.merchants.show', compact('merchant'));
    }
}
