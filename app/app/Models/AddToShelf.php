<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddToShelf extends Model
{
    use HasFactory;
    protected $fillable=['Pox_id','Barcode_id'];
}

