<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreCover extends Model
{
    use HasFactory;

    protected $fillable=[
        'cover_request_id',
        'shipment_src'
    ];
}
