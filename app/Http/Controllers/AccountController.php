<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AccountController extends Controller
{
    public function index() {
        $accounts = Account::all();
        return view('accounts.index', compact('accounts'));

    }

//    public function create() {
//        Account::query()->
//    }
    //
}
