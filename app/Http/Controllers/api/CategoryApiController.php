<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response as ResponseAlias;
use Exception;

class CategoryApiController extends Controller
{
    /**
     * Returns a list of categories by type.
     */
    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get a list of categories by type",
     *     description="Returns a list of categories filtered by type. The 'type' parameter is required.",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="The type of categories to filter by",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Categories successfully retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Categories successfully retrieved."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Category")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing required parameter 'type'",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The 'type' parameter is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error retrieving categories",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving categories."),
     *             @OA\Property(property="error", type="string", example="Error message details here")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $type = $request->query('type');

            if (!$type) {
                return ResponseAlias::json([
                    'success' => false,
                    'message' => 'The "type" parameter is required.',
                ], 400);
            }

            $categories = Category::where('type', $type)->get();

            return ResponseAlias::json([
                'success' => true,
                'data' => $categories,
                'message' => 'Categories successfully retrieved.',
            ], 200);
        } catch (Exception $e) {
            return ResponseAlias::json([
                'success' => false,
                'message' => 'Error retrieving categories.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
