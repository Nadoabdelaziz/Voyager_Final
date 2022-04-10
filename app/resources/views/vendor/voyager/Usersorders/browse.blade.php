@extends('voyager::master')
@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))
@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> إنشاء طلب تغليف من العميل
        </h1>

        @foreach($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')

<style>

table, th, td 
{
  border: 5px solid black;
  font-size: larger;
}

</style>

@php 
  $string="123456";
  $arr=str_split($string,3);
@endphp

<table id="table" class="table table-striped table-bordered">
<tr>
    <!-- <th>رقم القطعة</th> -->
    <!-- <th>   
      @foreach ($arr as $row)
      
      {{$row}}

      @endforeach

    </th> -->
    
    <th>رقم الصندوق</th>
    <th>رقم القطعة</th>
    <th>رقم الاضافة للرف</th>
    <th>الرف | العمود</th>
    <th>مصدر الشحن</th>
    <th>ابعاد القطعة</th>
    <th>وزن القطعة</th>
    <th> </th>

    <?php
      /*
          <th>Product Images</th>
      */
    ?>


  </tr>

  
  @php
    $x=0;
  @endphp


  @foreach($Users_orders as $order)

  @php
    $x++;
  $string="123125";

  @endphp

   <tr>
  

     <td>{{$order->user_id}}</td>
     <td>{{$order->Product_arrival_id}}</td>
     <td>{{$order->Product_Shelf_id}} </td>
     <td>{{$order->Shelf . "|" .$order->row }}</td>
     <td>{{$order->	Source_Market}}</td>
     <td>{{$order->Product_Dimension}}</td>
     <td>{{$order->Product_Weight	}}</td>
     <td></td>

     


      <td>

      <input name="my_checkbox[]" class="chexo" type="checkbox"  style="width:50px;height:30px;" value="{{$order->id}}">

      
      </td>

      
      
  </tr>


@endforeach




</table>


</body>



<table class="table table-striped table-bordered">
  <tr>
    <th>
      <button id="done_key" style="font-size: 20px;" class="btn btn-primary btn-lg" type="submit"> تأكيد الشحن من العميل </button>
    </th>

    <th>
    <h2 id="post_btn" ></h2>
    </th>
  </tr>
</table>

</html>




@stop




@section('javascript')

<script>
        
        $(document).ready(function() 
        {



          var zzz=0;
          var stringo;
          var res;

          var ids=[];




              $('.chexo').change(function check(){

                $('.chexo').each(function(idx, el){
                    if($(el).is(':checked'))
                    {  
                        var selectedValue = $(el).val();
   
                    }

                    $("#post_btn").html(selectedValue);
                    $("#post_btn").css("color","white");

                    
                });
                
                ids.push($("#post_btn").html());


              });

            
            

            $('#done_key').on('click',function(){
                // alert(ids);
              
                  $.ajax({
                  type: "POST",
                  url: '/coverrequests_array',// This is what I have updated
                  data: JSON.stringify(ids),
                  dataType: "json",
                  contentType : "application/json",
              }).done(function() {
                location.reload(false);
              })
              .fail(function(){
                  alert("sth went wrong :(( ");
              })

            });



 

            
        
        });
        
        </script>

@stop