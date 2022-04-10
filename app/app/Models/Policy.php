<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $fillable=[
    'Type_Order','Reciver_name','Country',
    'no_items','Product_weight','policy_number',
    'status','order_id','reference'];

}
