<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as ResponseAlias;

class TransactionController extends Controller
{
    /**
     * Повертає список усіх транзакцій з категоріями
     */
    public function index(): JsonResponse
    {
        $transactions = Transaction::with('category', 'account')
            ->orderBy('created_at', 'desc')
            ->get();

        return ResponseAlias::json([
            'success' => true,
            'data' => $transactions
        ], 200);
    }

    /**
     * Створює нову транзакцію (deposit або withdrawal)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:deposit,withdrawal'],
            'account_id' => ['required', 'exists:accounts,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            // Створення транзакції
            $transaction = Transaction::create([
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'account_id' => $validated['account_id'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'] ?? null,
                'created_at' => now(),
            ]);

            // Оновлення балансу акаунта
            if ($validated['type'] === 'deposit') {
                Account::where('id', $validated['account_id'])->increment('amount', $validated['amount']);
            } else {
                Account::where('id', $validated['account_id'])->decrement('amount', $validated['amount']);
            }

            DB::commit();

            return ResponseAlias::json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data' => $transaction
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            return ResponseAlias::json([
                'success' => false,
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
