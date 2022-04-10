<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipppeditem extends Model
{
    use HasFactory;
    
    protected $fillable=['order_id','','reciever_name','no_items','policy_number','final_weight','reference'];

}
