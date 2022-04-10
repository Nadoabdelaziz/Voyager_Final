
@extends('voyager::master')


@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i ></i> باركود الخانات
        </h1>
    </div>
@stop




@section('content')


<table class="table table-striped table-bordered">


<tr style="font-size: 20px">
    <th>الخانة</th>
    <th>الباركود</th>

</tr>
@foreach($shelf as $shelfe)
    @foreach($row as $rowe)


    <tr style="font-size: 20px">
    <td>{{$shelfe->name}} {{$rowe->name}}</td>
     <td>{!! DNS2D::getBarcodeHTML('4445645655', 'QRCODE') !!}</td>

</tr>

@endforeach
@endforeach

</table>



@stop