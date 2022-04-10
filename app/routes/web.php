<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Response;

use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\AddToShelfController;
use App\Http\Controllers\coverrequestsController;
use App\Http\Controllers\PreCoverController;
use App\Http\Controllers\PackwindowController;

use App\Http\Controllers\UserwindowController;
use App\Http\Controllers\SecondcoversController;


use App\Http\Controllers\AlreadyCoveredController;

use App\Http\Controllers\PolicyController;

use App\Http\Controllers\ShippeditemsController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// route for the ajax request of PreCover
Route::post('PreCover/{myid}', 'App\Http\Controllers\PreCoverController@PreCover');



Route::get('/', function () {
    return view('home');
});



Route::get('contactus', function () {
    return view('Contact_us');
});


Route::get('shop_ship', function () {
    return view('shop_ship');
});


Route::get('privacy', function () {
    return view('privacy-policy');
});


Route::get('aboutus', function () {
    return view('about-us');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


/*
Route::delete('/arrival', 'App\Http\Controllers\ArrivalController@destroy')->name('arrival.destroy');
*/

/*
// Suggest Shelf for User //
Route::get('admin/arrivals/{id?}','App\Http\Controllers\ArrivalController@hamleler');
*/

/*

Route::delete('Arrival/{id}', array('as' => 'arrival.destroy','uses' => 'App\Http\Controllers\ArrivalController@destroy'));
*/


/*
Route::post('coverrequests/{id}', array('as' => 'arrival.create','uses' => 'App\Http\Controllers\coverrequestsController@create'));
*/



//  Route::post('coverrequests_new/{st_order_id}/{nd_order_id}',[
//      'as'   => 'coverrequests_new',
//      'uses' => 'App\Http\Controllers\coverrequestsController@second_cover',
//  ]); 


Route::post('coverrequests_new/{first_order}/{second_order}', 'App\Http\Controllers\coverrequestsController@second_cover');

Route::post('coverrequests_old/{the_order_id}', 'App\Http\Controllers\coverrequestsController@Cover_Status_Change');


Route::post('CurrentShips/{the_href_order_id}', 'App\Http\Controllers\coverrequestsController@Href_Cover');



Route::post('coverrequests_array', 'App\Http\Controllers\coverrequestsController@Array_Cover');



Route::post('remove_cover/{the_order_id}', 'App\Http\Controllers\coverrequestsController@remove_cover');




Route::post('Already_Covered/{the_order_id}', 'App\Http\Controllers\AlreadyCoveredController@alreadyCovered');



Route::post('Policy/{the_order_id}', 'App\Http\Controllers\PolicyController@ProceedToolicy');




Route::post('Policy_To_Shipped/{the_order_id}', 'App\Http\Controllers\PolicyController@Policy_Done');



Route::post('Shippped_To_Arrived/{the_order_id}', 'App\Http\Controllers\PolicyController@FinalArrived');





//return item from worker

Route::post('return_item_from_worker/{the_order_id}', 'App\Http\Controllers\ReturnItemController@Return_Item_worker');





//return item from user

Route::post('remove_arrived_item/{the_order_id}', 'App\Http\Controllers\ReturnItemController@Return_Item');










// Policy Page 

Route::get('Policy_added/{the_order_id}', 'App\Http\Controllers\PolicyController@Get_PolicyInfo');







//PDF 

Route::post('DomPdf/{the_href_order_id}', 'App\Http\Controllers\coverrequestsController@DOMPDF');


// Route::post('currentships', 'App\Http\Controllers\coverrequestsController@Href_Cover');







Route::post('coverrequests/{id}',[
    'as'   => 'coverrequests',
    'uses' => 'App\Http\Controllers\coverrequestsController@Recover',
]); 


Route::post('Shippeditems/{req_id}/{user_id}',[
    'as'   => 'Shippeditems',
    'uses' => 'App\Http\Controllers\ShippeditemsController@create',
]);
/*
Route::get('/admin/usersorders','App\Http\Controllers\coverrequestsController@Checked')->name('coverrequests');
*/


Route::delete('Arrival/{id}', array('as' => 'arrival.ArriveToshelf','uses' => 'App\Http\Controllers\ArrivalController@ArriveToshelf'));

/*
Route::view('barcode', 'barcode');
*/

Route::post('Packwindow/{id}', array('as' => 'Packwindow.Arrive','uses' => 'App\Http\Controllers\PackwindowController@Arrive'));

Route::get('/barcode', [ArrivalController::class, 'index'])->name('generate.barcode');

Route::get('/ShelfBarcode', [ArrivalController::class, 'index2'])->name('generates.barcode');


Route::get('/Invoice', [ArrivalController::class, 'index3'])->name('generates.Invoice');


/*
Route::get('/search/', 'App\Http\Controllers\ArrivalController@search')->name('search');
*/

//searches for the order information to display in PackWindows page (حالةالقطعة)
Route::get('packwindows', 'App\Http\Controllers\AddToShelfController@index');
Route::get('packwindows/action', 'App\Http\Controllers\AddToShelfController@action')->name('packwindows.action');




//searches for the User information to display in UserWindows page (حالةالمسخدم)
Route::get('userwindows', 'App\Http\Controllers\UserwindowController@index');
Route::get('userwindows/action', 'App\Http\Controllers\UserwindowController@action')->name('userwindows.action');


Route::post('secondcovers/{id}', array('as' => 'secondcovers.Cover','uses' => 'App\Http\Controllers\SecondcoversController@Cover'));


Route::post('userwindows/{id}', array('as' => 'userwindows.UserRegister','uses' => 'App\Http\Controllers\UserwindowController@UserRegister'));















