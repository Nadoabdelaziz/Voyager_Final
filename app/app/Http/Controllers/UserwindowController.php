<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Userwindow;
use App\Models\Arrival;
use App\Models\Orderstatus;
use App\Models\User;
use App\Models\Packwindow;

use DB;
use storage;



class UserwindowController extends Controller{


    
    function index(){

        return redirect('/admin/userwindows');
    }



    
    public function UserRegister($id){

        $user=User::where('id',$id)->first();
        
        $userData = array(

            
            'Name' => $user->name, 
            'Country'=> $user->address,
            'Email'=> $user->email,
            'Phone' => $user->phone_number,
            'Box_ID' => $user->id,


            /*
            // error in taking image value into Usersorders Table

            'Product_image'=> $arrival->images,
            */
    );

        Userwindow::create($userData);

        return redirect('/admin/users');
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
                        
                        $data = DB::table('userwindows')
                        ->where('Box_ID', 'like', $query)
    
                        ->get();

                        $Packs_Windows=Packwindow::where('User_Number',$query)->get();
                        $count=0;
                        
                    }
                else
                    {
    
                    }
                    $total_row = $data->count();
                    
                    if($total_row > 0)
                    {
                        
                    foreach($data as $row)
                        {
                            foreach($Packs_Windows as $pack){
                                $count++;
                            $output .=
                        
                        
                        '

                            <br>
                            <h2>بيانات العميل</h2>
                            <br>

                                

                            </tr>

                            <tr>
                            <th><label class="control-label" for="name">رقم الصندوق </label></th>
                            <td><div name="$row->Source_Market">'.$row->Box_ID	.'</div></td>
    
                            </tr>


                            
                            <tr>

                        <th><label class="control-label" for="name">اسم العميل</label></th>
                        <td><div name="$row->order_status">'.$row->Name.'</div></td>

                        </tr

                        <tr>
                        <th><label class="control-label" for="name">البلد</label></th>
                        <td><div name="$row->User_Number">'.$row->Country.'</div></td>
                        </tr>
                        


                        <tr>

                        <th><label class="control-label" for="name">الأيميل</label></th>
                        <td><div name="$row->Arrival_ID">'.$row->Email.'</div></td>

                        </tr>


                        <tr>

                        <th><label class="control-label" for="name">رقم الهاتف</label></th>
                        <td><div name="$row->Source_Market">'.$row->Phone.'</div></td>

                        </tr>

                        <tr>
                        <br><br><br><br>
                        <h1 margin-left="30px"class="success">'.$count.' : بيانات القطعة </h1>
                        <br>
                        </tr>

                        
                        <th>
                        <br><br>
                        <h2> "'.$pack->Arrival_ID.'"القطعة رقم</h2>
                        </th>


                        <tr>

                        <th><label class="control-label" for="name">حالة الشحنة</label></th>
                        <td><div name="$row->order_status">'.$pack->order_status.'</div></td>

                        </tr





                        <tr>
                        <th><label class="control-label" for="name">رقم الصندوق</label></th>
                        <td><div name="$row->User_Number">'.$pack->User_Number.'</div></td>
                        </tr>
                        


                        <tr>

                        <th><label class="control-label" for="name">رقم القطعة</label></th>
                        <td><div name="$row->Arrival_ID">'.$pack->Arrival_ID.'</div></td>

                        </tr>


                        <tr>

                        <th><label class="control-label" for="name">مصدر الشحن</label></th>
                        <td><div name="$row->Source_Market">'.$pack->Source_Market.'</div></td>

                        </tr>



                        <tr>
                        <th><label class="control-label" for="name">ابعاد القطعة</label></th>
                        <td><div name="$row->Source_Market">'.$pack->P_Dimensions.'</div></td>

                        </tr>


                        <tr>
                        <th><label class="control-label" for="name">وزن القطعة</label></th>
                        <td><div name="$row->Source_Market">'.$pack->P_Weight	.'</div></td>

                        </tr>



                        <tr>
                        <th><label class="control-label" for="name">تاريخ تسجيل القطعة</label></th>
                        <td><div name="$row->Source_Market">'.$pack->created_at	.'</div></td>

                        </tr>

                        
                        <tr>
                        <th><label class="control-label" for="name">باركود تسجيل القطعة  </label></th>
                        <td><div name="$row->Source_Market">'.$pack->Arrive_Barcode.'</div></td>

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
                        <td><div> <img src="'.asset('storage/'.$pack->Arrival_Images).'" alt="" height="200px" width="300px">
                        </div></td>
                        


                        
                     

                        
                        <td><div> <img src="'.asset('storage/'.$pack->General_Images).'" alt="" height="200px" width="300px">
                        </div></td>
                        </tr>




                        <th>
                        <br><br><br><br><br><br>
                        <h2>تفاصيل تخزين القطعة</h2>
                        </th>





                        <tr>
                        <th><label class="control-label" for="name">رقم الاضافة للرفوف</label></th>
                        <td><div name="$row->Source_Market">'.$pack->Add_To_Shelf_ID.'</div></td>

                        </tr>



                        <tr>
                        <th><label class="control-label" for="name">الرف | العمود</label></th>
                        <td><div name="$row->Source_Market">'.$pack->Shelf.''.$pack->Row.'</div></td>

                        </tr>

                        
                        <tr>
                        <th><label class="control-label" for="name">باركود تخزين القطعة  </label></th>
                        <td><div name="$row->Source_Market">'.$pack->AddShelf_Barcode.'</div></td>

                        </tr>


                        <th>
                        <br><br><br><br><br><br>
                        <h2>تفاصيل تغليف القطعة</h2>
                        </th>




                        <tr>
                        <th><label class="control-label" for="name">رقم طلب التغليف</label></th>
                        <td><div name="$row->Source_Market">'.$pack->CoverRequest_ID.'</div></td>
                        </tr>


                        <tr>
                        <th><label class="control-label" for="name">رقم التغليف</label></th>
                        <td><div name="$row->Source_Market">'.$pack->ND_Taghleef_ID.'</div></td>

                        </tr>


                        <tr>
                        <th><label class="control-label" for="name"> الرف | العمود  </label></th>
                        <td><div name="$row->Source_Market">'.$pack->nd_shelf.''.$pack->nd_row.'</div></td>

                        </tr>



                        <tr>
                        <th><label class="control-label" for="name"> ابعاد القطعة المغلفة</label></th>
                        <td><div name="$row->Source_Market">'.$pack->nd_dimensions.'</div></td>

                        </tr>


                        <tr>
                        <th><label class="control-label" for="name"> وزن القطعة المغلفة</label></th>
                        <td><div name="$row->Source_Market">'.$pack->nd_weight.'</div></td>

                        </tr>

                        
                        
                        <tr>
                        <th><label class="control-label" for="name">مغلف مع شحنة رقم</label></th>
                        <td><div name="$row->Source_Market">'.$pack->ND_Packaged_Order_Id.'</div></td>

                        </tr>



                        <th>
                        <br><br><br><br>
                        <h2>صور التغليف</h2>
                        </th>



                        <tr>
                        <td><div> <img src="'.asset('storage/'.$pack->Cover_Images).'" alt="" height="200px" width="300px">
                        </div></td>
                        </tr>




                      
                        <th>
                        <br><br><br><br>
                        </th>


                        <tr>
                        <th><hr style="height:2px;border-width:0;color:gray;background-color:gray">
                        <br></th>
                        </tr>
                        
                            ';
                        }
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
