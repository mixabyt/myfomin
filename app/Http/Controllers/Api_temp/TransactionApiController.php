<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as ResponseAlias;

/**
 * @OA\Tag(
 *     name="Transactions",
 *     description="User transaction operations"
 * )
 */

class TransactionApiController extends Controller
{
    /**
     * Returns a list of all transactions with categories
     */

    /**
     * @OA\Get(
     *     path="/api/transactions",
     *     summary="Get all transactions with categories and accounts",
     *     description="Returns a list of all transactions ordered by creation date (descending)",
     *     tags={"Transactions"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved transaction list",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Transaction")
     *             )
     *         )
     *     )
     * )
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
     * Creates a new transaction (deposit or withdrawal)
     */
    /**
     * @OA\Post(
     *     path="/api/transactions",
     *     summary="Create a new transaction (deposit or withdrawal)",
     *     description="Adds a new transaction and updates the account balance.",
     *     tags={"Transactions"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"type","account_id","category_id","amount"},
     *             @OA\Property(property="type", type="string", enum={"deposit","withdrawal"}, example="deposit", description="Transaction type"),
     *             @OA\Property(property="account_id", type="integer", example=1, description="Account ID"),
     *             @OA\Property(property="category_id", type="integer", example=3, description="Category ID"),
     *             @OA\Property(property="amount", type="number", format="float", example=1500.50, description="Transaction amount"),
     *             @OA\Property(property="description", type="string", example="Deposit from client", description="Transaction description (optional)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Transaction created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Transaction created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Transaction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation error: type field is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error creating transaction",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to create transaction"),
     *             @OA\Property(property="error", type="string", example="SQLSTATE[23000]: Integrity constraint violation ...")
     *         )
     *     )
     * )
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

            // Create transaction
            $transaction = Transaction::create([
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'account_id' => $validated['account_id'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'] ?? null,
                'created_at' => now(),
            ]);

            // Update account balance
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
