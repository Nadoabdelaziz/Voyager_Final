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
use App\Models\Coverrequest;
use DB;
use Session;





class PreCoverController extends Controller
{
    public function PreCover($myid){

        $cover_req=Coverrequest::where('id',$myid)->first();

        $return_value=$cover_req->Product_Weight;

        // return $return_value;

        return $return_value;


    }



}
