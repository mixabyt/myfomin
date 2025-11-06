<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


/**
 * @OA\Tag(
 *     name="Accounts",
 *     description="API Endpoints for managing accounts"
 * )
 */
class AccountApiController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/accounts",
     *     summary="Get list of all accounts",
     *     tags={"Accounts"},
     *     @OA\Response(
     *         response=200,
     *         description="List of accounts returned successfully",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Account"))
     *     )
     * )
     */
    public function index() {
        $accounts = Account::orderBy('id')->get();
        return json_encode($accounts);
    }

    /**
     * @OA\Post(
     *     path="/api/accounts",
     *     summary="Create a new account",
     *     tags={"Accounts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "amount"},
     *             @OA\Property(property="name", type="string", maxLength=20, example="Main Account"),
     *             @OA\Property(property="amount", type="number", example=5000.75)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Account created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Account")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */

    public function store()
    {
        $validated = request()->validate([
            'name' => ['required', 'string', 'max:20'],
            'amount' => ['required', 'numeric', 'max:100000000'],
        ]);

        $accounts = Account::create($validated);

        return response()->json($accounts, ResponseAlias::HTTP_CREATED);

    }
    /**
     * @OA\Delete(
     *     path="/api/accounts/{id}",
     *     summary="Delete an account",
     *     tags={"Accounts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of account to delete",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Account deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Account not found"
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/accounts/{id}",
     *     summary="Update an existing account",
     *     tags={"Accounts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of account to update",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "amount"},
     *             @OA\Property(property="name", type="string", example="Updated Account"),
     *             @OA\Property(property="amount", type="number", example=7000.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Account updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Account")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Account not found"
     *     )
     * )
     */

    public function update($id) {
        $account = Account::where('id', $id)->update([
            'name' => request('name'),
            'amount' => request('amount'),
        ]);

        return response()->json($account, ResponseAlias::HTTP_OK);
    }
}
