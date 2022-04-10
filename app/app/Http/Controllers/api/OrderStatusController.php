<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Orderstatus;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class OrderStatusController extends OrionController
{
    use DisableAuthorization;

    protected $model = Orderstatus::class;  
    // or "App\Models\Post"
    
}
