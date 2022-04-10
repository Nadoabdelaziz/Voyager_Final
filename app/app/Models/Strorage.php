<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strorage extends Model
{
    use HasFactory;

    protected $fillable=['pack_id','Source','pack_price','user_id'];

}
