@extends('voyager::master')
use

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="{{ $dataType->icon }}"></i> شحنات المستخدمين
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
table, th, td {
  border: 5px solid black;
  font-size: larger;
}
</style>


<table class="table table-striped table-bordered">
<tr>
    <th>User ID</th>
    <th>Order ID</th>
    <th>Shelf | Row</th>
    <th>Date Created</th>
    <th>Action</th>



  </tr>



</body>
</html>


@stop