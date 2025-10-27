<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $type = request('radio');
        $accountID = request('account_id');
        $amount = request('amount');
        Transaction::create([
            'type' => $type,
            'amount' => $amount,
            'account_id' => $accountID,
            'created_at' => now(),
        ]);

       if ($type === 'deposit') {
           Account::where('id', $accountID)->increment('amount', $amount);
       } else {
           Account::where('id', $accountID)->decrement('amount', $amount);
       }
        return redirect(route("accounts.index"));

    }
}

