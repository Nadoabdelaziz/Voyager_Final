<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usersorder extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'Product_Shelf_id',
        'Product_arrival_id',
        'Shelf',
        'row',
        'Source_Market',
        'Product_image',
        'Product_Dimension',
        'Product_Weight'
    ];
}
