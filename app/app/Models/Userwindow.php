<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userwindow extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'Country',
        'Email',
        'Phone',
        'created_at',
        'Box_ID'
    ];
}
