<?php

namespace App\Http\Controllers;
use Input;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coverrequest;
use App\Models\AddToShelf;
use App\Models\Orderstatus;
use App\Models\Usersorder;
use App\Models\Item;
use App\Models\Arrival;

use App\Models\Packwindow;
use App\Models\ShipTalabat;
use App\Models\Recoverenquiry;
use App;


use App\Models\Packremoval;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataRestored;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;







class coverrequestsController extends Controller

{
    
    public function Recover($id) { 
    
        $User_Order=Usersorder::where('id',$id)->first();

        $covers=Coverrequest::all();

        // get the order on shelf id as to delete the record on shelf as a new recover is requested

        $order_on_shelf=AddToShelf::where('id',$User_Order->Product_Shelf_id)->first();



        $recover = array(

            'order_id' => $User_Order->Product_arrival_id,
            'user_id'  => $User_Order->user_id,
            'Product_Dimension' =>$User_Order->Product_Dimension,
            'Product_Weight' =>$User_Order->Product_Weight,
            'no_of_items' => 1,
            'Paid_Amount'=> 20,
            'reference'=> 'asdadadadadasd',
            'order_statuss'=>'asdadasd'
            
        );

        Coverrequest::create($recover);

        Orderstatus::where('order_id',$User_Order->Product_arrival_id)->update([

            'status'=>'تم طلب تغليفة من العميل',
        
        ]);

        $O_status=Orderstatus::where('order_id',$User_Order->Product_arrival_id)->first();
        $cover_r=Coverrequest::where('order_id',$User_Order->Product_arrival_id)->first();


                Packwindow::where('Arrival_ID',$User_Order->Product_arrival_id)->update([

                        'order_status'=>$O_status->Status,
                        'CoverRequest_ID'=> $cover_r->id,
                        
                ]);


        $User_Order->delete();
        $order_on_shelf->delete();


        return redirect('/admin/coverrequests');

        }


            
    public function second_cover($id1,$id2) { 
    
        if($id1 != 0  && $id2 !=0 ){

            
            $first_order=Usersorder::where('id',$id1)->first();
            $second_order=Usersorder::where('id',$id2)->first();


            $first_user=$first_order->user_id;
            $second_user=$second_order->user_id;



            if($first_user == $second_user )
            {
                        
                    $covers=Coverrequest::all();
            
                    // get the order on shelf id as to delete the record on shelf as a new recover is requested
            
                    $first_order_on_shelf=AddToShelf::where('id',$first_order->Product_Shelf_id)->first();
            
                    $second_order_on_shelf=AddToShelf::where('id',$second_order->Product_Shelf_id)->first();




                    // $talabat= array(
                    //     'req_code'      => 'code',
                    //     'Goal_Country'  => 'الكويت',
                    //     'Box_id'        => $first_user,
                    //     'email '        => 'email@email.com',
                    //     'item_status'   => 'موجودة في المستودع',
                    //     'items_weight'  =>  $first_order->Product_Weight + $second_order->Product_Weight,
                    // );

                    // ShipTalabat::create($talabat);



                    
                    $recover = array
                    (

                        'order_id' => $first_order->Product_arrival_id,
                        'user_id'  => $first_order->user_id,
                        'Product_Dimension' =>$first_order->Product_Dimension + $second_order->Product_Dimension,
                        'Product_Weight' =>$first_order->Product_Weight + $second_order->Product_Weight,
                        'no_of_items' => 2,
                        'Paid_Amount'=> 20,
                        'reference'=> $id1.' '.$id2,
                        'order_statuss'=>'موجودة في المسودع',
                        'sec_order_id'=>$second_order->Product_arrival_id,
                        'st_Date_created'=>$first_order->created_at,
                        'nd_Date_created'=>$second_order->created_at,
                        'st_Source'=>$first_order->Source_Market,
                        'nd_source' => $second_order->Source_Market ,
                        'st_Weight'=>$first_order->Product_Weight ,
                        'nd_weight'=> $second_order->Product_Weight ,
                        'st_image'=>$first_order->Product_image ,
                        'nd_image'=>$second_order->Product_image,
                        'st_shelf' =>$first_order->Shelf .$first_order->row ,
                        'nd_shelf' => $second_order->Shelf.$second_order->row

                    );

                    Coverrequest::create($recover);






                    
                    $first_order->delete();
                    $second_order->delete();


                    $first_order_on_shelf->delete();
                    $second_order_on_shelf->delete();

                    return redirect('/admin/coverrequests');
            }

            else {
                $msg="Orders Must be by the same User";
                return $msg;
            }
            
    
    
        }

        else if ($id1 !=0 && $id2 == 0 ) {


            $first_order=Usersorder::where('id',$id1)->first();

            $first_user=$first_order->user_id;

    
            $covers=Coverrequest::all();
    
            // get the order on shelf id as to delete the record on shelf as a new recover is requested
    
            $first_order_on_shelf=AddToShelf::where('id',$first_order->Product_Shelf_id)->first();
    


            $talabat= array(
                'order_id' => $first_order->Product_arrival_id,
                'user_id'  => $first_order->user_id,
                'Product_Dimension' =>$first_order->Product_Dimension,
                'Product_Weight' =>$first_order->Product_Weight,
                'no_of_items' => 2,
                'Paid_Amount'=> 20,
                'reference'=> $id1,
                'order_statuss'=>'موجودة في المسودع',
                'st_Date_created'=>$first_order->created_at,
               'st_Source'=> $first_order->Source_Market,
                'st_Weight'=>$first_order->Product_Weight,
                'st_shelf' =>$first_order->Shelf .$first_order->row ,
            );

            Coverrequest::create($talabat);

            

        
            $first_order->delete();


            $first_order_on_shelf->delete();
        

            return redirect('/admin/coverrequests');

        }



        else if ($id1==0 && $id2==0) {
            $msg="please choose any orders";
            return $msg;
        }


       
    }





    public function Array_Cover(Request $request){

        //retrieve json object 

        foreach($request->all() as $key => $value) {
            $decode[$key] = json_decode($value);
        }


        $theorders_count = count($decode);



        $first_order=Usersorder::where('id',$decode[0])->first();




        $first_user=$first_order->user_id;
        


        $recover = array
        (

            'user_id'  => $first_user,
            'Product_Dimension' =>$first_order->Product_Dimension, //not donee
            'Product_Weight' =>$first_order->Product_Weight,
            'no_of_items' => $theorders_count,
            'Paid_Amount'=> 20,
            'reference'=> json_encode($decode),
            'order_statuss'=>'موجودة في المسودع',
        );
        Coverrequest::create($recover);



        $the_cover_req=Coverrequest::orderBy('id', 'desc')->first();



        $order_status_enquiries=array(

            'id' => $the_cover_req->id,
            'status'=>'موجودة في المستودع',
        );
        Recoverenquiry::create($order_status_enquiries);

    
        foreach ($decode as $key ) {

            $vars=Usersorder::where('id',$key)->first();
            
            AddToShelf::where('id',$vars->Product_Shelf_id)->first()->delete();

            $vars->delete();

        }


        return 0;

    }



        public function Cover_Status_Change($order_id){

            // $the_status_respnose=Coverrequest::where('id',$order_id)->first();


            // update the status enquiry (حالة طلب التغليف)

            $the_pack_removal=array(
                'cover_order_id'=>$order_id,
            );
            Packremoval::create($the_pack_removal);




            $the_status_enquiry=Recoverenquiry::where('id',$order_id)->update([
                'status'=>'بإنتظار السحب',
            ]);


            $new_status=Recoverenquiry::where('id',$order_id)->first();




            $thecover=Coverrequest::where('id',$order_id)->first();


            $thecover->update([
                'order_statuss' =>$new_status->status,
            ]);



            foreach (json_decode($thecover->reference) as $key) {
                Item::where('id',$key)->update([
                    'store_status' => $new_status->status,
                ]);
            }



            // $the_status_respnose->update([
    
            //     'order_statuss' => "بإنتظار السحب"
            // ]);


            

            return $new_status->status;
        }    
    



        public function DOMPDF($arr_items){   

            $the_cover_id=Coverrequest::where('reference',$arr_items)->first();


            $the_items=json_decode($arr_items);

            $i=0;
    
    
            
            foreach ($the_items as $key) {
              $arrays[$i]=Item::where('id',$key)->first();
              $i++;    
            }

            $view = 'voyager::bread.browse';

            $slug = "currentships";
    
            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
    
    
            $view = "voyager::$slug.browse";
        
            $pdf = 
            PDF::loadView("Invoice",compact('arrays','the_cover_id'));


        // instantiate and use the dompdf class
        // $pdf = App::make('dompdf.wrapper');
        // $pdf = PDF::loadView("welcome")->setOptions(['defaultFont' => 'sans-serif']);

        // $pdf->loadView($view);
        return $pdf->stream();
        }




        public function Href_Cover($arr_items){

            
            $arrays=[];

            $the_items=json_decode($arr_items);

            $i=0;


            
            foreach ($the_items as $key) {
            $arrays[$i]=Item::where('id',$key)->first();
            $i++;    
            }
            
            
                
            $view = 'voyager::bread.browse';

            $slug = "currentships";

            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();


            if (view()->exists("voyager::$slug.browse")) {
                $view = "voyager::$slug.browse";
            }

            return Voyager::view($view, compact(
                'arr_items','dataType','arrays'
            ));

                // return redirect()->route("voyager.currentships.index")->with( 'the_h_order' , $arr);


        }


        public function remove_cover($order_id){



            $Cover_Status=Recoverenquiry::where('id',$order_id)->first();
            

            $Cover_Status->update([
                    'status'=> 'مسحوبة من المستودع',
            ]);



            $the_cover=Coverrequest::where('id',$order_id)->first();


            $the_cover->update([
                'order_statuss'=>$Cover_Status->status,
            ]);




            foreach (json_decode($the_cover->reference) as $key) {
                Item::where('id',$key)->update([
                    'store_status' => $the_cover->order_statuss,
                ]);
            }


            
            

            $second_Cover_arrival=array(
                // 'source_market'=> $the_cover,
                // 'General_images'=> $the_cover,
                'id'=> $order_id,
                'Product_Weight'=> $the_cover->Product_Weight,
                'Pox_id'=>$the_cover->user_id ,
                'box_id'=>$the_cover->user_id ,
                'Second' => 123

            );
            Arrival::create($second_Cover_arrival);

            

            

            Packremoval::where('cover_order_id',$order_id)->delete();


            return redirect('/admin/coverrequests');


        }



    
    
    
}


