<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packwindow extends Model
{
    use HasFactory;

    protected $fillable=[
        'Date_Of_Arrival',
        'User_Number',
        'Source_Market',
        'Shelf',
        'row',
        'P_Dimensions',
        'P_Weight',
        'Arrival_ID',
        'order_status',
        'ND_Packaged_Order_Id',
        'Arrival_Images',
        'General_Images',
        'Arrive_Barcode',
        'AddShelf_Barcode'
    ];

}
