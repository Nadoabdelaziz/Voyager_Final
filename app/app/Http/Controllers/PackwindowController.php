<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Packwindow;
use App\Models\Arrival;
use App\Models\Orderstatus;



class PackwindowController extends Controller

{         

    public function Arrive($id)
    {   
        $arrival=Arrival::where('id',$id)->first();

        // create new record at PacketWiindows Table 


        //create new status record for new item in Orderstatus table with status value: تم الوصول
        
        $status = array(
            'order_id' => $arrival->id,
            'Status'   => 'تم الوصول'
        );

        Orderstatus::create($status);


        $order_state=Orderstatus::where('order_id',$arrival->id)->first();

         $OrderData = array(
  
                 'Date_Of_Arrival' => $arrival->created_at, 
                 'Arrival_ID' => $arrival->id,
                 'User_Number'=> $arrival->box_id,
                 'Source_Market'=> $arrival->source_market,
                 'P_Dimensions'=> $arrival->Product_dimension,
                 'P_Weight'=>$arrival->Product_Weight,
                 'Arrive_Barcode' => $arrival->Barcode_id,	
                 'order_status' => $order_state->Status,
                 'General_Images' => $arrival->General_images,
                 'Arrival_Images' =>$arrival->Arrival_Images
         );

         Packwindow::create($OrderData);

         return redirect('admin/arrivals');

    }

}
