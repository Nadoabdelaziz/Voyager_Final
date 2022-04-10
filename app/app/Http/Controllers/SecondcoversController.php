<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orderstatus;
use App\Models\Coverrequest;
use App\Models\Secondcover;
use App\Models\Shipppeditem;
use App\Models\Packwindow;



class SecondcoversController extends Controller

{
    public function Cover($id){

        $Cover=Secondcover::where('id',$id)->first();

        $Cover_req=Coverrequest::where('id',$Cover->package_id)->first();



        Orderstatus::where('order_id',$Cover_req->order_id)->update([

            'Status'=>'تم شحنة',
        
        ]);


        $O_status=Orderstatus::where('order_id',$Cover_req->order_id)->first();


            Packwindow::where('Arrival_ID',$Cover_req->order_id)->update
            ([

                'order_status'=>$O_status->Status,
                'ND_Taghleef_ID'=> $id,
                'ND_Packaged_Order_Id'=> $Cover_req->sec_order_id,
                'Cover_Images' => $Cover->package_images
                        
            ]);



        


        $Shippped_item = array(
            'order_id' => $Cover_req->order_id,
            'cover_id' => $Cover_req->id,
            'user_id'  => $Cover_req->user_id
        );

        Shipppeditem::create($Shippped_item);

        
        $Cover_req->delete();
        $Cover->delete();
        

        return redirect('admin/shipppeditems');


    }

}