<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Models\Usersorder;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class UserOrdersController extends OrionController
{
    use DisableAuthorization;

    protected $model = Usersorder::class;  
    // or "App\Models\Post"
    
}
