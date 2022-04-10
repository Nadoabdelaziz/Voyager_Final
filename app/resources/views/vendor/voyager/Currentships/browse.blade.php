
@extends('voyager::master')







<!-- @if (session('the_h_order'))
    <div class="alert alert-success">
        {{ session('the_h_order') }}
    </div>

@else
<div>adasdasd</div>

@endif -->




                @php 
                $i=1;
                @endphp


                @section('content')




                <style>

                table ,td
                {
                    border-color:black; /*grey*/
                    border-style:solid; 
                    border-width:1px;
                    width:1450px;
                font-size: larger;
                table-layout: auto;
                height:100px;
                padding: 17px;
                text-align: left;
                }

                th{
                    border-color:black; /*grey*/
                    border-style:solid; 
                    border-width:1px;
                    text-align: center;
                    font-size: larger;
                    padding: 9px;


                }



                </style>


                <table  style="background-color:PaleTurquoise" id="table" >
                <tr styke="">

                    <th> # </th>
                    <th>رقم الصندوق</th>
                    <th>رقم القطعة</th>
                    <th>تاريخ الوصول</th>
                    <th>مصدر القطعة</th>
                    <th>وزن القطعة</th>
                    <th>صور القطعة</th>
                    <th>حالة التخزين</th>
                    <th> </th>
                </tr>


                <!-- @if(!empty($arr_items)) -->

                <!-- @foreach (json_decode($arr_items) as $area)
                <tr>
                   <td>{{
                $area; 
                }}</td>
                </tr>
                @endforeach
                @endif -->

                @if (!empty($arrays))


                @foreach ($arrays as $arr)
                <tr>
                <td>{{$i}}</td>
                   <td>{{$arr->user_id}}</td>
                   <td>{{$arr->order_id}}</td>
                   <td>{{$arr->created_at}}</td>
                   <td>{{$arr->Source}}</td>
                   <td>{{$arr->weight}}</td>
                   <td><img src="{{asset('storage/'.$arr->pics)}}" alt="" height="70px" width="70px" &nbsp &nbsp &nbsp &nbsp &nbsp> <img src="{{asset('storage/'.$arr->sec_pics)}}" alt="" height="70px" width="70px"></td>
                   <td>{{$arr->store_status}}</td>
                   <td></td>
                </tr>
                @php
                $i++;
                @endphp
                @endforeach

                @endif

                </table>


                </body>



                <table class="table table-striped table-bordered">
                <tr>
                   
                </tr>
                </table>

                </html>



                @stop


