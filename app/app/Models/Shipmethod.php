<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipmethod extends Model
{
    use HasFactory;

    protected $fillable=['order_id','policy_number','final_weight','no_of_items','reciever_name'];

}
