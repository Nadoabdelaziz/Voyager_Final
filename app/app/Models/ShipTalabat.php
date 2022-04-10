<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipTalabat extends Model
{
    use HasFactory;

    protected $fillable=['req_code','Goal_Country','Box_id','email','item_status','items_weight','order_id','number_items'];

}
