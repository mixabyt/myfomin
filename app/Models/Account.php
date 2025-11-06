<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



/**
 * @OA\Schema(
 *     schema="Account",
 *     type="object",
 *     title="Account",
 *     description="Account model schema",
 *     required={"id", "name", "amount"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Main Account"),
 *     @OA\Property(property="amount", type="number", example=5000)
 * )
 */
class Account extends Model
{

    protected $table = 'accounts';
    protected $guarded = [];
    public $timestamps = false;
}
