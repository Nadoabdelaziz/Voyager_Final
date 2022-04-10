<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipppeditem;
use App\Models\Coverrequest;
use App\Models\Orderstatus;






class ShippeditemsController extends Controller

{
    public function create($id,$user_id) { 

        $userData = array('order_id' => $id,'user_id'=> $user_id);
        Shipppeditem::create($userData);
    
        Orderstatus::where('id',$id)->update(['Status'=>'تم شحنها']);

        
        $blog=Coverrequest::where('order_id',$id)->first();
        $blog->delete();   
        
 


        return redirect('/admin/orderstatuses');

        }
}
