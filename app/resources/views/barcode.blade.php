
@extends('voyager::master')


@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i ></i> باركود الشحنات
        </h1>
    </div>
@stop




@section('content')


<table class="table table-striped table-bordered">
@foreach($posts as $post)

<tr style="font-size: 20px">
    <th>رقم الشحنة</th>
    <th>رقم الوصول</th>
    <th>رقم الخانة</th>
    <th>ابعاد الشحنة</th>
    <th>وزن الشحنة</th>
    <th>الباركود</th>




  </tr>


    <tr style="font-size: 20px">
    <td>{{$post->id}}</td>
    <td>{{$post->package_id}}</td>
    <td>{{$post->shelf}} | {{$post->row}}</td>  
    <td>{{$post->package_dimensions}}</td>
    <td>{{$post->package_weight}}</td>

     <td>{!! DNS2D::getBarcodeHTML('4445645655', 'QRCODE') !!}</td>
    </tr>

</table>
@endforeach
@stop