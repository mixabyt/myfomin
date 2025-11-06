<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AccountApiController extends Controller
{
    public function index() {
        $accounts = Account::orderBy('id')->get();
        return json_encode($accounts);
    }

    public function store()
    {
        $validated = request()->validate([
            'name' => ['required', 'string', 'max:20'],
            'amount' => ['required', 'numeric', 'max:100000000'],
        ]);

        $accounts = Account::create($validated);

        return response()->json($accounts, ResponseAlias::HTTP_CREATED);

    }
    //
    public function destroy($id)
    {
        $deletedCount = Account::destroy($id);

        if ($deletedCount > 0) {
            return response()->noContent();
        }

        return response()->json([
            'error' => 'Account not found.'
        ], ResponseAlias::HTTP_NOT_FOUND);
    }

    public function update($id) {
        $account = Account::where('id', $id)->update([
            'name' => request('name'),
            'amount' => request('amount'),
        ]);

        return response()->json($account, ResponseAlias::HTTP_OK);
    }
}
