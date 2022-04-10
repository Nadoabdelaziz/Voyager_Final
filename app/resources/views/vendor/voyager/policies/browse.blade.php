@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> البوليصة 
        </h1>
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if(!empty($dataType->order_column) && !empty($dataType->order_display_column))
                <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-primary btn-add-new">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}" data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @foreach($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')

<!-- <div id="overlay" class="the_bbtn">
  <div id="text">Overlay Text</div>
</div> -->

<!-- <div style="padding:20px">
  <h2>Overlay with Text</h2>
  <button id="mybtno">Turn on overlay effect</button>
</div> -->


    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        
                        @if ($isServerSide)
                            <form method="get" class="form-search">
                                <div id="search-input">
                                    <div class="col-2">
                                        <select id="search_key" name="key">
                                            @foreach($searchNames as $key => $name)
                                                <option value="{{ $key }}" @if($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <select id="filter" name="filter">
                                            <option value="contains" @if($search->filter == "contains") selected @endif>contains</option>
                                            <option value="equals" @if($search->filter == "equals") selected @endif>=</option>
                                        </select>
                                    </div>
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control" placeholder="{{ __('voyager::generic.search') }}" name="s" value="{{ $search->value }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info btn-lg" type="submit">
                                                <i class="voyager-search"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
                            </form>
                        @endif
                        <div class="table-responsive">
                            
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        @if($showCheckboxColumn)
                                            <th class="dt-not-orderable">
                                                <input type="checkbox" class="select_all">
                                            </th>
                                        @endif
                                        @foreach($dataType->browseRows as $row)
                                        <th>
                                            @if ($isServerSide && in_array($row->field, $sortableColumns))
                                                <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                            @endif
                                            {{ $row->getTranslatedAttribute('display_name') }}
                                            @if ($isServerSide)
                                                @if ($row->isCurrentSortField($orderBy))
                                                    @if ($sortOrder == 'asc')
                                                        <i class="voyager-angle-up pull-right"></i>
                                                    @else
                                                        <i class="voyager-angle-down pull-right"></i>
                                                    @endif
                                                @endif
                                                </a>
                                            @endif
                                        </th>
                                        @endforeach
                                        <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($dataTypeContent as $data)
                                    <tr>
                                        @if($showCheckboxColumn)
                                            <td>
                                                <input type="checkbox" name="row_id" id="checkbox_{{ $data->getKey() }}" value="{{ $data->getKey() }}">
                                                
                                            </td>
                                        @endif
                                        
<!-- 
                                        <div id="overlay" class="the_bbtn">
                                            <div id="text">Overlay Text</div>
                                        </div> -->

                                        
                                        @foreach($dataType->browseRows as $row)
                                        
                                            @php
                                            if ($data->{$row->field.'_browse'}) {
                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                            }
                                            @endphp
                                            <td>
                                                
                                            
                                                @if (isset($row->details->view))
                                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                @elseif($row->type == 'image')
                                                    <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                @elseif($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])
                                                @elseif($row->type == 'select_multiple')
                                                    @if(property_exists($row->details, 'relationship'))

                                                        @foreach($data->{$row->field} as $item)
                                                            {{ $item->{$row->field} }}
                                                        @endforeach

                                                    @elseif(property_exists($row->details, 'options'))
                                                        @if (!empty(json_decode($data->{$row->field})))
                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                @if (@$row->details->options->{$item})
                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ __('voyager::generic.none') }}
                                                        @endif
                                                    @endif

                                                    @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                        @if (@count(json_decode($data->{$row->field})) > 0)
                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                @if (@$row->details->options->{$item})
                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ __('voyager::generic.none') }}
                                                        @endif

                                                @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))

                                                    {!! $row->details->options->{$data->{$row->field}} ?? '' !!}

                                                @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                    @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                        {{ \Carbon\Carbon::parse($data->{$row->field})->formatLocalized($row->details->format) }}
                                                    @else
                                                        {{ $data->{$row->field} }}
                                                    @endif
                                                @elseif($row->type == 'checkbox')
                                                    @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                        @if($data->{$row->field})
                                                            <span class="label label-info">{{ $row->details->on }}</span>
                                                        @else
                                                            <span class="label label-primary">{{ $row->details->off }}</span>
                                                        @endif
                                                    @else
                                                    {{ $data->{$row->field} }}
                                                    @endif
                                                @elseif($row->type == 'color')
                                                    <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                @elseif($row->type == 'text')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                @elseif($row->type == 'text_area')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    @if(json_decode($data->{$row->field}) !== null)
                                                        @foreach(json_decode($data->{$row->field}) as $file)
                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                {{ $file->original_name ?: '' }}
                                                            </a>
                                                            <br/>
                                                        @endforeach
                                                    @else
                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                            Download
                                                        </a>
                                                    @endif
                                                @elseif($row->type == 'rich_text_box')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                @elseif($row->type == 'coordinates')
                                                    @include('voyager::partials.coordinates-static-image')
                                                @elseif($row->type == 'multiple_images')
                                                    @php $images = json_decode($data->{$row->field}); @endphp
                                                    @if($images)
                                                        @php $images = array_slice($images, 0, 3); @endphp
                                                        @foreach($images as $image)
                                                            <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                        @endforeach
                                                    @endif
                                                @elseif($row->type == 'media_picker')
                                                    @php
                                                        if (is_array($data->{$row->field})) {
                                                            $files = $data->{$row->field};
                                                        } else {
                                                            $files = json_decode($data->{$row->field});
                                                        }
                                                    @endphp
                                                    @if ($files)
                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                            <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                            @endforeach
                                                        @else
                                                            <ul>
                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                <li>{{ $file }}</li>
                                                            @endforeach
                                                            </ul>
                                                        @endif
                                                        @if (count($files) > 3)
                                                            {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                        @endif
                                                    @elseif (is_array($files) && count($files) == 0)
                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                    @elseif ($data->{$row->field} != '')
                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                        @else
                                                            {{ $data->{$row->field} }}
                                                        @endif
                                                    @else
                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                    @endif
                                                @else
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <span>{{ $data->{$row->field} }}</span>
                                                @endif
                                            </td>
                                            
                                        @endforeach
                                        
                                        <td class="no-sort no-click bread-actions">


                                        <!-- Pop Form -->

                                        
                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                        <div class="overlay" >
                                            <div class="text">


                                            

                                        <form action="{{ url('Policy_added',$data->order_id ) }}" method="GET">
                                        {{ csrf_field() }}



                                                
                                                <h1  style="text-align:right; color:black;">تكوين بوليصة الشحن</h1>\<br>
                                                <h3 class="alert alert-primary" align="right" style="color:black; height:80px" role="alert">
                                                    الرجاء تكوين بوليصة شحن وفقآ للمعلومات التالية
                                                </h3>
                                        <br><br>
                                                <h2  style="padding-right:25px; text-align:right; color:black;">معلومات المستلم </h2>
                                                <br>
                                                <h3  style="padding-right:25px; text-align:right; color:black;">    {{$data->Reciver_name}}  : &nbsp; اسم المستلم  </h3> 
                                                <hr><br>
                                                <h3  style="padding-right:25px; text-align:right; color:black;">  {{$data->Country}} kuwait  &nbsp; : العنوان  </h3> 
                                                <hr><br>
                                                <h3  style="padding-right:25px; text-align:right; color:black;"> {{$data->Country}} kuwait &nbsp; : المدينة</h3> 
                                                <hr><br>
                                                <h3  style="padding-right:25px; text-align:right; color:black;">  {{$data->Country}} kuwait &nbsp;:البلد</h3> 
                                                
                                                <br>
                                                <hr>
                                                <br>

                                                <h2  style="padding-right:25px; text-align:right; color:black;">الرمز البريدي </h2>
                                                <br>
                                                <hr>
                                                <h3  style="padding-right:25px; text-align:right; color:black;">رقم الهاتف  :   2027824940 </h3> 
                                                <hr>
                                                <br>
                                                <hr>
                                                <br>


                                                <h2  style="padding-right:25px; text-align:right; color:black;"> معلومات الشحنة </h2>
                                                <hr><br>
                                                <h3  style="padding-right:25px; text-align:right; color:black;"> رقم الجزء    &nbsp;&nbsp; الوزن الفعلي  &nbsp; &nbsp; الوزن الحجمي </h3> 
                                                <hr><br>
                                                <h3  style="padding-right:25px; text-align:right; color:black;"> {{$data->Product_weight}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; {{$data->Product_weight}} &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; {{$data->no_items}} &nbsp; &nbsp;</h3> 
                                                <br>
                                                <hr>
                                                <br>
                                    

                                                <h3  style="padding-right:25px; text-align:right; color:black;">  {{$data->Product_weight}} &nbsp;: وزن الشحنة النهائي  </h3> 
                                                <hr><br>
                                                <h3  style="padding-right:25px; text-align:right; color:black;">  {{$data->Product_weight}} &nbsp;:  محتويات الشحنة  </h3> 

                                                
                                                <br>
                                                <hr>
                                                <br>

                                                <h2  style="padding-right:25px; text-align:right; color:black;">معلومات البوليصة</h2>
                                                <br>
                                                <hr>

                                                <input id="policy_number" name="policy_number" style="font-size:28px; height:10%; margin-left:150px; width:80%; text-align:right; color:black;" type="text" placeholder="رقم البوليصة">
                                                <br><hr><br>
                                                <input  style="font-size:28px; margin-left:150px; height:10%; width:80%;text-align:right; color:black;" type="text" placeholder="شركة الشحن ">
                                                <br><br>
                                                <hr>
                                                <br><br>

                                                <div>
                                                <h2 align="middle"> PDF تحميل البوليصة </h2>
                                                <h3 align="middle"> قم بسحب الملفات هنا</h3>

                                                <input id="policy_pdf" name="policy_pdf" style="margin-left:550px; width:20%; height:20%; text-align:center; color:black;" type="file"  name="upload" accept="application/pdf,application/vnd.ms-excel" />

                                                </div>

                                                <br><hr><br>
                                                
                                                
                                                
                                                <h2  style="padding-right:25px; text-align:right; color:black;"> معلومات الإيصال </h2>
                                                <br>
                                                <hr>
                                                <input  style="font-size:28px; margin-left:150px; width:80%; height:10%; text-align:right; color:black;" type="text" placeholder=" سعر البضاعة داخل الشحنة">
                       
                                                
                                                
                                                <br><br><hr> <br><br>



                                                <!-- <a class="btn btn-primary" id="close">إلغاء</a> -->
                                                <!-- <a class="btn btn-danger btn-sm the_bbtn">close</a> -->


                                                <button  class="btn btn-success btn-sm" onclick="this.value='Confirmed'"> حفظ </button>



                                            </form>
                                            </div>
                                        </div>

                                    <!-- Hamburger Menu -->

                                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

                                    <!-- Top Navigation Menu -->
                                    <!-- Navigation links (hidden by default) -->
                                    <div class="dropdown">
                                        <button class="dropbtn fa fa-bars btnss"></button>
                                        <div class="myDropdown dropdown-content ">
                                        <a href="#"> عرض صور الشحنة</a>

                                            <a href="#"> تغيير معلومات البوليصة  </a>
                                            <a href="#">  تغيير البطاقة التسويقية </a>
                                            <a href="#"> طباعة الايصال  </a>
                                            <a class="mybtno">بوليصة الشحنة</a>
                                            <a href="#">طباعة الايصال</a>
                                            <a href="#"> عرض صور الشحنة</a>
                                            <a href="#"> عرض  إثبات الوزن</a>
                                            <a href="#"> طباعة طلب الشحن</a>
                                            <a href="#"> طباعة باركودات الصناديق</a>
                                            <a href="#"> مشاهدة تاريخ حركة الشحنة</a>
                                            <a href="#"> تكوين شحنة أضافية</a>
                                            <a href="#">  حذف صور إثبات الوزن </a>



                                        </div>
                                    </div>                              
                                    
                                    

                                
                                <style>
                                    .overlay {
                                        position: fixed;
                                        display: none;
                                        overflow-y:auto;
                                        width: 100%;
                                        height: 100%;
                                        top: 0;
                                        left: 0;
                                        right: 0;
                                        bottom: 0;
                                        background-color: rgba(0,0,0,0.5);
                                        z-index: 2;
                                        cursor: pointer;
                                        }

                                    .text{
                                        overflow-y:auto;
                                        position: absolute;
                                        background-color:white;
                                        height:70%;
                                        width:70%;
                                        top: 50%;
                                        left: 50%;
                                        font-size: 10px;
                                        color: black;
                                        transform: translate(-50%,-50%);
                                        /* -ms-transform: translate(-50%,-50%); */
                                        }

                                    .center {
                                        overflow-x:hidden;
                                        overflow-y:auto;
                                        position:fixed;
                                        /* background:rgba(10,0,0,0.6); */
                                        background-color:grey;
                                        z-index:999;
                                        width:60%;
                                        height:60%;
                                        display:inline;
                                        }

                                    .hideform {
                                        display: none;
                                    }
                                        /* Style the navigation menu */
                                    /* Dropdown Button */
                                    .dropbtn {
                                    background-color: #3498DB;
                                    color: black;
                                    padding: 16px;
                                    font-size: 16px;
                                    border: none;
                                    cursor: pointer;
                                    }

                                    /* Dropdown button on hover & focus */
                                    .dropbtn:hover, .dropbtn:focus {
                                    background-color: #2980B9;
                                    }

                                    /* The container <div> - needed to position the dropdown content */
                                    .dropdown {
                                    position: relative;
                                    display: inline-block;
                                    }

                                    /* Dropdown Content (Hidden by Default) */
                                    .dropdown-content {
                                        
                                    display: none;
                                    position: absolute;
                                    background-color: #f1f1f1;
                                    min-width: 160px;
                                    z-index: 2;
                                    width: 33.33%;
                                    float: left;
                                    position: relative; 
                                    
                                    /* <-- added declaration */
                                    }

                                    /* Links inside the dropdown */
                                    .dropdown-content a {
                                    color: black;
                                    padding: 12px 16px;
                                    text-decoration: none;
                                    display: block;
                                    }

                                    /* Change color of dropdown links on hover */
                                    .dropdown-content a:hover {background-color: #ddd}

                                    /* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
                                    .show {display:block;}
                                    </style>

                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ]) }}</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                    's' => $search->value,
                                    'filter' => $search->filter,
                                    'key' => $search->key,
                                    'order_by' => $orderBy,
                                    'sort_order' => $sortOrder,
                                    'showSoftDeleted' => $showSoftDeleted,
                                ])->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')

    <!-- Hamburger Menu Function -->


    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {



            $('.btnss').click(function()
            {
                $(this).data('clicked', true);
            });

            $('.mybtno').on('click',function(){
                $(this).data('clicked', true);

                // document.getElementsByClassName("overlay")[1].style.display = "block";

            });

            
            $('.the_bbtn').on('click',function(){
                $(this).data('clicked', true);

                // document.getElementsByClassName("overlay")[0].style.display = "none";

            });



            $('.btnss').click(function(){

                $('.btnss').each(function(idx, el){

                    if($(el).data('clicked'))
                    {            
                        document.getElementsByClassName("myDropdown")[idx].classList.toggle("show");
                        
                    }
                    
                });
            });


            $('.mybtno').click(function(){

                $('.mybtno').each(function(idx, el){

                    if($(el).data('clicked'))
                    {                    
                        
                        document.getElementsByClassName("overlay")[idx].style.display = "block";
                    }
                    
                });

            });



            $('.the_bbtn').click(function(){

                $('.the_bbtn').each(function(idx, el){

                    if($(el).data('clicked'))
                    {                    
                        
                        document.getElementsByClassName("overlay")[ids].style.display = "none";
                    }
                    
                });

            });


            // $(".btnss").click(function(){
            //     document.getElementsByClassName("myDropdown")[1].classList.toggle("show");

            // });


            // $('.mybtno').on('click',function(){
            //     document.getElementsByClassName("overlay")[1].style.display = "block";

            // });

            
            // $('.the_bbtn').on('click',function(){
            //     document.getElementsByClassName("overlay")[0].style.display = "none";

            // });


            

            
            
            $('#show').on('click', function () {
                $('.center').show();
                $(this).hide();
            })

            $('#close').on('click', function () {
                $('.center').hide();
                $('#show').show();
            })




            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => $orderColumn,
                        "language" => __('voyager::datatable'),
                        "columnDefs" => [
                            ['targets' => 'dt-not-orderable', 'searchable' =>  false, 'orderable' => false],
                        ],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.side-body').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.side-body').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });


        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 1]), true)) }}"></a>');
                    }else{
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 0]), true)) }}"></a>');
                    }

                    $('#redir')[0].click();
                })
            })
        @endif
        $('input[name="row_id"]').on('change', function () {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });
    </script>
@stop

