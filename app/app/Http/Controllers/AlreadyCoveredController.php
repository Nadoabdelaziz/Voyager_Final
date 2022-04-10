<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Arrival;
use App\Models\Orderstatus;
use App\Models\AddToShelf;
use App\Models\Usersorder;
use App\Models\ShipTalabat;

use App\Models\Secondcover;
use App\Models\Shelf;
use App\Models\Row;
use App\Models\Packwindow;
use App\Models\User;
use App\Models\Item;
use App\Models\Coverrequest;

use App\Models\Alreadycovered;



use DB;
use Session;





class AlreadyCoveredController extends Controller
{

    public function alreadyCovered($the_order_id){

        $the_already_covered=Alreadycovered::where('order_id',$the_order_id)->first();


        $the_ship_talabat=array(
            'order_id' => $the_order_id,
            'Box_id' =>$the_already_covered->user_id ,
            'req_code' => $the_already_covered->reference,
            'Goal_Country' => 'الكويت',
            'email' => 'admin@admin.com',
            'item_status' =>$the_already_covered->status,
            'items_weight' => $the_already_covered->product_weight,
            'number_items' => $the_already_covered->no_of_items
        );
        ShipTalabat::create($the_ship_talabat);



        Alreadycovered::where('order_id',$the_order_id)->delete();

        return redirect("admin/ship-talabats");
    }
}