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
use App\Models\Policy;



use App\Models\Finalarrival;

use App\Models\Shipmethod;


use App\Models\Shipppeditem;





use App\Models\Coverrequest;
use App\Models\Alreadycovered;



use DB;
use Session;





class PolicyController extends Controller
{
    public function ProceedToolicy($order_id){

        $the_ship_talabat=ShipTalabat::where('order_id',$order_id)->first();

        $Policy=array(
            'order_id'=>$order_id,
            'Country' =>$the_ship_talabat->Goal_Country,
            'status'=>'بأنتظار البوليصة',
            'Product_weight'=>$the_ship_talabat->items_weight ,
            'no_items'=>$the_ship_talabat-> number_items,
            'Reciver_name'=>$the_ship_talabat->email,
            'Type_Order'=>'شحنة اضافية' ,
            'reference' => $the_ship_talabat->req_code
        );

        Policy::create($Policy);


        $the_ship_talabat->delete();

        return redirect("/admin/policies");
        
    }



    public function Get_PolicyInfo($the_order_id){

        $nameValue=$_GET['policy_number'];



            
        $the_policy_order_id=Policy::where('order_id',$the_order_id)->first();


        $the_policy_order_id->update([

            'policy_number'=>$nameValue
        ]);


        if((empty($_GET['policy_pdf']))){

            $the_policy_order_id->update([

                'status'=>'بأنتظار أرفاق البوليصة بالشحنة'
            ]);
        }
        else {

            $the_policy_order_id->update([

                'status'=>'تم تسليم الشحنة لشركة الشحن'
            ]);

            $the_ship_method=array(
                'order_id' => $the_order_id,
                'policy_number' =>$nameValue,
                'final_weight' => $the_policy_order_id->Product_weight,
                'no_of_items' => $the_policy_order_id ->no_items,
                'reciever_name' =>$the_policy_order_id->Reciver_name
            );

            Shipmethod::create($the_ship_method);

        }




        return redirect("/admin/policies");

    }


    public function Policy_Done($the_order_id){

        $the_policy= Policy::where('order_id',$the_order_id)->first();


        $the_shipped_item=array(
            'order_id'=>$the_order_id,
            'reciever_name'=>$the_policy->Reciver_name,
            'no_items' => $the_policy->no_items,
            'policy_number' => $the_policy->policy_number,
            'final_weight' => $the_policy->Product_weight,
            'reference'    => $the_policy->reference
        );

        Shipppeditem::create($the_shipped_item);


        Shipmethod::where('order_id',$the_order_id)->delete();

        $the_policy->delete();
        return redirect("/admin/shipppeditems");



    }



    public function FinalArrived($the_order_id){
        $the_last_arrival=array(
            'order_id' =>$the_order_id
        );

        Finalarrival::create($the_last_arrival);

        Shipppeditem::where('order_id',$the_order_id)->delete();


        return redirect("/admin/finalarrivals");




    }

}