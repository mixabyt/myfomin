<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Category",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Electronics"),
 *     @OA\Property(property="type", type="string", example="product")
 * )
 */


class Category extends Model
{
    protected $table = 'categories';
    public $timestamps = false;
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
