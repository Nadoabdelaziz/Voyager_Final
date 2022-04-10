<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Arrival;
use App\Models\Orderstatus;
use App\Models\AddToShelf;
use App\Models\Usersorder;
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





class ArrivalController extends Controller
{


        public function index()
        {
                $users=Secondcover::all();
                /*
                return view('barcode',compact('a'));
                */
                return view('barcode',array('posts' => $users));
        }

        public function index2()
        {
                $shelf=Shelf::all();
                $row=Row::all();
                /*
                return view('barcode',compact('a'));
                */
                return view('ShelfBarcode',array('shelf' => $shelf,'row' => $row));
        }


        public function index3()
        {
                $shelf=Shelf::all();
                $row=Row::all();
                /*
                return view('barcode',compact('a'));
                */
                return view('Invoice',array('shelf' => $shelf,'row' => $row));
        }
    

        public function ArriveToshelf($order_id)
        {

                $order_on_shelf=AddToShelf::where('pack_id',$order_id)->first();

                $the_arrival=Arrival::where('id',$order_on_shelf->pack_id)->first();



                if(!$the_arrival->Second  == null){
                        
                        $elcoverrequest=Coverrequest::where('id',$the_arrival->id)->first();

                        $elcoverrequest->update([

                         'order_statuss' => 'موجودة في المستودع'       
                        ]);



                        $new_already_covered=array(
                         'order_id' => $elcoverrequest->id,
                         'user_id' => $elcoverrequest->user_id,
                         'product_dimensions' =>$elcoverrequest->Product_Dimension,
                         'product_weight' => $elcoverrequest->Product_Weight,
                         'no_of_items' =>$elcoverrequest->no_of_items,
                         'paid_amount' =>$elcoverrequest->Paid_Amount ,
                         'reference' => $elcoverrequest->reference,
                         'status' => $elcoverrequest->order_statuss
                        );

                        Alreadycovered::create($new_already_covered);

                        

                        $the_arrival->delete();
                        $order_on_shelf->delete();
                        $elcoverrequest->delete();
                        return redirect('/admin/alreadycovereds');

                        // henaaaa ///
                }







                Orderstatus::where('order_id',$order_on_shelf->pack_id)->update([

                        'Status'=>'مخزنة',
                    
                ]);

                $O_status=Orderstatus::where('order_id',$order_on_shelf->pack_id)->first();


                Packwindow::where('Arrival_ID',$order_on_shelf->pack_id)->update([

                        'order_status'=>$O_status->Status,
                        'Add_To_Shelf_ID' => $order_on_shelf->id,
                        'AddShelf_Barcode' => $order_on_shelf->Barcode_id,
                        'Shelf'=> $order_on_shelf->shelf_name,
                        'Row'=>$order_on_shelf->row_number
                    
                ]);


                //get the objects of order in {arrivals,AddToShelf} Tabales by the order id from the AddToShelf Browse Page

                $arrival=Arrival::where('id',$order_id)->first();  




                // add a new record to the usersorders table

                $userData = array(

                        
                        'user_id' => $arrival->box_id, 
                        'Product_Shelf_id'=> $order_on_shelf->id,
                        'Product_arrival_id'=> $arrival->id,
                        'Shelf' => $order_on_shelf->shelf_name,
                        'row' => $order_on_shelf->row_number,
                        'Source_Market'=> $arrival->source_market,
                        'Product_Dimension'=>$arrival->Product_dimension,
                        'Product_Weight'=>$arrival->Product_Weight



                        /*
                        // error in taking image value into Usersorders Table

                        'Product_image'=> $arrival->images,
                        */
                );

                Usersorder::create($userData);



                $the_user=Usersorder::orderBy('id', 'desc')->first();


                $item_data = array(

                        'id'      =>$the_user->id,
                        'user_id' => $the_user->user_id, 
                        'order_id'=> $the_user->Product_arrival_id,
                        'shelf' => $the_user->Shelf,
                        'row' => $the_user->row,
                        'Source'=> $the_user->Source_Market,
                        'Product_Dimension'=>$the_user->Product_Dimension,
                        'pics' => $arrival->General_images,
                        'sec_pics' => $arrival->Arrival_Images,
                        'weight'=>$the_user->Product_Weight,
                        'store_status' =>'موجودة في المسودع',
                        'created_at' => $the_user->created_at
                );

                Item::create($item_data);




                // delete the Order record from the arrivals table

                $arrival->delete();
                
                return redirect('/admin/add-to-shelves');


        }


}
