<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable=['id','created_at','updated_at','user_id','Source','weight','pics','sec_pics','store_status','order_id','shelf','row'];

}
