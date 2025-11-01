<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $type = request('type');
        $categories = Category::where('type', $type)->get();
        return response()->json($categories);
    }
}
