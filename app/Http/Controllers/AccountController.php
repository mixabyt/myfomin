<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function index() {
        $accounts = Account::orderBy('id')->get();
        return view('accounts.index', compact('accounts'));

    }

    public function create() {
        Account::create([
            'name' => request('name'),
            'amount' => request('amount'),
        ]);
        return redirect(route("accounts.index"));
    }
    //
    public function delete(): RedirectResponse
    {
        $id = request('id');
        $deletedCount =  Account::destroy($id);
        if ($deletedCount > 0) {
            return redirect(route('accounts.index'));
        } else {
            return redirect("/nigar");
        }
    }

    public function update() {
        $id = request('id');
        Account::where('id', $id)->update([
            'name' => request('name'),
            'amount' => request('amount'),
        ]);

        return redirect(route('accounts.index'));
    }
}
