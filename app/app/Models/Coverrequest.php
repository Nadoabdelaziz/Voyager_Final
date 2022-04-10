<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coverrequest extends Model
{
    use HasFactory;

    protected $fillable=['order_id','user_id','Product_Dimension','Product_Weight','no_of_items','Paid_Amount','reference','order_statuss','sec_order_id','nd_Date_created','st_Source','nd_source','st_Weight','nd_weight','st_image','nd_image','st_Date_created','nd_shelf','st_shelf'];
}
