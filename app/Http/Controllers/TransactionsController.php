<?php

namespace App\Http\Controllers;

use App\Traits\Remote;

class TransactionsController extends Controller
{
    use Remote;

    /**
     * Display a listing of the transactions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $transactions = $this->getTransactions(request()->get('from_date'), request()->get('to_date'));

        if (! isset($transactions->data) || empty($transactions->data)) {
            return view('transactions.index', compact('transactions'))->with('warning', 'No transactions found.');
        }

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Display the specified transaction.
     *
     * @param   $transaction_id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($transaction_id)
    {
        $transaction = $this->getTransaction($transaction_id);

        if (! $transaction) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }
    
        return view('partials.transactions.show', compact('transaction'));
    }
}
