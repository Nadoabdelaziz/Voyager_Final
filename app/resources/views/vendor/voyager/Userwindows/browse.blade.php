@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> حالة الصندوق
        </h1>
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



<html>
 <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <h3 align="center"></h3><br />
   <div class="panel panel-default">
    <h4 align="center" class="panel-heading">بحث حالة الصندوق</h4><br>
    <div class="panel-body">
     <div class="form-group">
      <input type="text" name="search" id="userwindows" class="form-control" placeholder="بحث حالة الصندوق" /> <br><br><br><br>
     </div>
     <div class="table-responsive">
      <h3 align="center">: النتيجة <span id="total_records"></span></h3><br>
    

      <table class="table table-striped table-bordered">
       <thead>



       </thead>
       <tbody>

       </tbody>
      </table>
     </div>
    </div>    
   </div>
  </div>
 </body>
</html>




<script>
$(document).ready(function(){

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"{{ route('userwindows.action') }}",
   method:'GET',
   data:{query:query},
   dataType:'json',
   success:function(data)
   {
    $('tbody').html(data.table_data);
    $('#total_records').text(data.total_data);
   }
  })
 }

 $(document).on('keyup', '#userwindows', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });
});
</script>








@stop





