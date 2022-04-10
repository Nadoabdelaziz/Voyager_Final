<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Spatial;

class Arrival extends Model
{
    use Spatial;

    use HasFactory;

    public function scopeSubcategories($query) {
   return $query->where('box_id', '!=', null);
}
protected $fillable=['Second','id','Pox_id','box_id','source_market','Product_Weight','Product_dimension','General_Images','Arrival_Images','Barcode_id'];



}
