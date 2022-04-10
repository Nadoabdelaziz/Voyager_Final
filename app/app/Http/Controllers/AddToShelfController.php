<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddToShelf;
use App\Models\Packwindow;
use DB;
use storage;

class AddToShelfController extends Controller

{

    function index(){

        return redirect('/admin/packwindows');
    }


    // searches for the order id in the PackWindows {حالة القطعة} 
    function action(Request $request)
    {
            if($request->ajax())
                {

                $output = '';
                $query = $request->get('query');
                if($query != '')
                {
                    
                    $data = DB::table('packwindows')
                    ->where('Arrival_ID', 'like', $query)

                    ->get();
                    
                }
            else
                {

                }
                $total_row = $data->count();
                
                if($total_row > 0)
                {
                    
                foreach($data as $row)
                    {
                       
                        $output .=

                        '
                        <tr>

                        <th><label class="control-label" for="name">حالة الشحنة</label></th>
                        <td><div name="$row->order_status">'.$row->order_status.'</div></td>

                        </tr

                        <tr>
                        <th><label class="control-label" for="name">رقم الصندوق</label></th>
                        <td><div name="$row->User_Number">'.$row->User_Number.'</div></td>
                        </tr>
                        


                        <tr>

                        <th><label class="control-label" for="name">رقم القطعة</label></th>
                        <td><div name="$row->Arrival_ID">'.$row->Arrival_ID.'</div></td>

                        </tr>


                        <tr>

                        <th><label class="control-label" for="name">مصدر الشحن</label></th>
                        <td><div name="$row->Source_Market">'.$row->Source_Market.'</div></td>

                        </tr>



                        <tr>
                        <th><label class="control-label" for="name">ابعاد القطعة</label></th>
                        <td><div name="$row->Source_Market">'.$row->P_Dimensions.'</div></td>

                        </tr>


                        <tr>
                        <th><label class="control-label" for="name">وزن القطعة</label></th>
                        <td><div name="$row->Source_Market">'.$row->P_Weight	.'</div></td>

                        </tr>



                        <tr>
                        <th><label class="control-label" for="name">تاريخ تسجيل القطعة</label></th>
                        <td><div name="$row->Source_Market">'.$row->created_at	.'</div></td>

                        </tr>

                        <tr>
                        <th><label class="control-label" for="name">باركود تسجيل القطعة  </label></th>
                        <td><div name="$row->Source_Market">'.$row->Arrive_Barcode.'</div></td>

                        </tr>


                        <th>
                        <br><br><br><br>
                        <h2>صور الوصول</h2>
                        </th>

                        <th>
                        <br><br><br><br>
                        <h2>الصور العامة </h2>
                        </th>




                        <tr>
                        <td><div> <img src="'.asset('storage/'.$row->Arrival_Images).'" alt="" height="200px" width="300px">
                        </div></td>
                        


                        
                     

                        
                        <td><div> <img src="'.asset('storage/'.$row->General_Images).'" alt="" height="200px" width="300px">
                        </div></td>
                        </tr>



                        <th>
                        <br><br><br><br><br><br>
                        <h2>تفاصيل تخزين القطعة</h2>
                        </th>





                        <tr>
                        <th><label class="control-label" for="name">رقم الاضافة للرفوف</label></th>
                        <td><div name="$row->Source_Market">'.$row->Add_To_Shelf_ID.'</div></td>

                        </tr>



                        <tr>
                        <th><label class="control-label" for="name">الرف | العمود</label></th>
                        <td><div name="$row->Source_Market">'.$row->Shelf.''.$row->Row.'</div></td>

                        </tr>


                        <tr>
                        <th><label class="control-label" for="name">باركود تخزين القطعة  </label></th>
                        <td><div name="$row->Source_Market">'.$row->AddShelf_Barcode.'</div></td>

                        </tr>


                        <th>
                        <br><br><br><br><br><br>
                        <h2>تفاصيل تغليف القطعة</h2>
                        </th>




                        <tr>
                        <th><label class="control-label" for="name">رقم طلب التغليف</label></th>
                        <td><div name="$row->Source_Market">'.$row->CoverRequest_ID.'</div></td>
                        </tr>


                        <tr>
                        <th><label class="control-label" for="name">رقم التغليف</label></th>
                        <td><div name="$row->Source_Market">'.$row->ND_Taghleef_ID.'</div></td>

                        </tr>


                        <tr>
                        <th><label class="control-label" for="name"> الرف | العمود  </label></th>
                        <td><div name="$row->Source_Market">'.$row->nd_shelf.''.$row->nd_row.'</div></td>

                        </tr>



                        <tr>
                        <th><label class="control-label" for="name"> ابعاد القطعة المغلفة</label></th>
                        <td><div name="$row->Source_Market">'.$row->nd_dimensions.'</div></td>

                        </tr>


                        <tr>
                        <th><label class="control-label" for="name"> وزن القطعة المغلفة</label></th>
                        <td><div name="$row->Source_Market">'.$row->nd_weight.'</div></td>

                        </tr>

                        
                        
                        <tr>
                        <th><label class="control-label" for="name">مغلف مع شحنة رقم</label></th>
                        <td><div name="$row->Source_Market">'.$row->ND_Packaged_Order_Id.'</div></td>

                        </tr>



                        <th>
                        <br><br><br><br>
                        <h2>صور التغليف</h2>
                        </th>



                        <tr>
                        <td><div> <img src="'.asset('storage/'.$row->Cover_Images).'" alt="" height="200px" width="300px">
                        </div></td>
                        </tr>



                        ';
                    }
                }


                else
                    {
                    $output =
                     '
                    <tr>
                        <td align="center" colspan="15">رقم القطعة غير صحيح</td>
                    </tr>
                    ';
                    }
                    $data = array(
                    'table_data'  => $output,
                    'total_data'  => $total_row
                );

                echo json_encode($data);
            }
    }
}



    
