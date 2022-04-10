<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alreadycovered extends Model
{
    use HasFactory;

    protected $fillable=['order_id','user_id','product_dimensions','product_weight','no_of_items','paid_amount','reference','status'];

}
