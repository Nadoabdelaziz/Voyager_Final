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
use App\Models\Returnitem;
use App\Models\Coverrequest;

use App\Models\Alreadycovered;



use DB;
use Session;





class ReturnItemController extends Controller
{

    public function Return_Item($the_order_id){

        $the_shelf_added=AddToShelf::where('pack_id',$the_order_id)->first();
        

        $the_return_item=array(
            'order_id' => $the_order_id,
            'status' => 'موجودة في المستودع',
            'store_place' => $the_shelf_added->shelf_name ."-".$the_shelf_added->row_number,
        );

        Returnitem::create($the_return_item);

        return redirect("/admin/returnitems");


    }


    public function Return_Item_worker($the_order_id){

        Returnitem::where('order_id',$the_order_id)->delete();
        AddToShelf::where('pack_id',$the_order_id)->delete();
        Usersorder::where('Product_arrival_id',$the_order_id)->delete();

        return redirect("/admin/returnitems");
    }
}