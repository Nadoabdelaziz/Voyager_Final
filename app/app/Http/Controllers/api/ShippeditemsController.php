<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Shipppeditem;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class ShippeditemsController extends OrionController
{
    use DisableAuthorization;

    protected $model = Shipppeditem::class;  
    // or "App\Models\Post"
    
}
