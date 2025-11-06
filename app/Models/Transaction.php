<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Transaction",
 *     type="object",
 *     title="Transaction",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="type", type="string", enum={"deposit","withdrawal"}, example="deposit"),
 *     @OA\Property(property="amount", type="number", format="float", example=500.75),
 *     @OA\Property(property="description", type="string", example="Payment received"),
 *     @OA\Property(property="account_id", type="integer", example=1),
 *     @OA\Property(property="category_id", type="integer", example=2),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-06T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-06T12:00:00Z"),
 *     @OA\Property(property="category", ref="#/components/schemas/Category"),
 *     @OA\Property(property="account", ref="#/components/schemas/Account")
 * )
 */
class Transaction extends Model
{
    protected $table = 'transactions';
    public $timestamps = false;
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
