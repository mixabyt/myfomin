<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Redirector;
class AccountController extends Controller
{
    public function index() {
        $accounts = Account::orderBy('id')->get();
        return view('accounts.index', compact('accounts'));

    }

    public function store(): Redirector|RedirectResponse
    {
        $validated = request()->validate([
            'name' => ['required', 'string', 'max:20'],
            'amount' => ['required', 'numeric', 'max:100000000'],
        ]);

        Account::create([
            'name' => $validated['name'],
            'amount' => $validated['amount'],
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
