<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returnitem extends Model
{
    use HasFactory;


    protected $fillable=[
        'store_place',
        'status',
        'user_id',
        'order_id'
    ];

}
