<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;
// use App\Http\Controllers\Api\ArrivalController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderStatusController;
use App\Http\Controllers\Api\ArrivalController;
use App\Http\Controllers\Api\AddToShelfController;






/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 Orion::resource('arrivals', App\Http\Controllers\api\ArrivalController::class);


Orion::resource('users', App\Http\Controllers\api\UserController::class);


Orion::resource('add-to-shelves', App\Http\Controllers\Api\AddToShelfController::class);


Orion::resource('orderstatus', App\Http\Controllers\Api\OrderStatusController::class);


Orion::resource('strorage', App\Http\Controllers\Api\StrorageController::class);




Orion::resource('coverrequests', App\Http\Controllers\Api\coverrequestsController::class);


Orion::resource('NewRow', App\Http\Controllers\Api\NewRowController::class);


Orion::resource('Packwindow', App\Http\Controllers\Api\PackwindowController::class);


Orion::resource('Secondcovers', App\Http\Controllers\Api\SecondcoversController::class);


Orion::resource('Shelf', App\Http\Controllers\Api\ShelfController::class);


Orion::resource('Shippeditems', App\Http\Controllers\Api\ShippeditemsController::class);


Orion::resource('Source', App\Http\Controllers\Api\SourceController::class);


Orion::resource('UserOrders', App\Http\Controllers\Api\UserOrdersController::class);


Orion::resource('Userwindow', App\Http\Controllers\Api\UserwindowController::class);








 