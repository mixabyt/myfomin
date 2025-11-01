<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{

    public function index()
    {
        // Отримуємо всі транзакції разом з їхніми категоріями
        $transactions = Transaction::with('category')
            ->orderBy('created_at', 'desc')
            ->get();

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
            'category_id' => request('category_id'),
            'created_at' => now(),
            'description' => request('description')
        ]);

        if ($type === 'deposit') {
            Account::where('id', $accountID)->increment('amount', $amount);
        } else {
            Account::where('id', $accountID)->decrement('amount', $amount);
        }
        return redirect(route("accounts.index"));
    }
}
