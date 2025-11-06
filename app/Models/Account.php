<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



/* @OA\Schema(
 *     schema="Account",
 *     type="object",
 *     title="Account model",
 *     required={"name", "amount"},
 *     @OA\Property(property="name", type="string", example="Bank card"),
 *     @OA\Property(property="amount", type="int", example="10")
* )
 */
class Account extends Model
{

    protected $table = 'accounts';
    protected $guarded = [];
    public $timestamps = false;
}
