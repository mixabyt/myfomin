<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response as ResponseAlias;
use Exception;

class CategoryController extends Controller
{
    /**
     * Повертає список категорій за типом.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $type = $request->query('type');

            if (!$type) {
                return ResponseAlias::json([
                    'success' => false,
                    'message' => 'Параметр "type" є обов’язковим.',
                ], 400);
            }

            $categories = Category::where('type', $type)->get();

            return ResponseAlias::json([
                'success' => true,
                'data' => $categories,
                'message' => 'Категорії успішно отримано.',
            ], 200);
        } catch (Exception $e) {
            return ResponseAlias::json([
                'success' => false,
                'message' => 'Помилка при отриманні категорій.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
