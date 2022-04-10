<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Userwindow;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class UserwindowController extends OrionController
{
    use DisableAuthorization;

    protected $model = Userwindow::class;  
    // or "App\Models\Post"
    
}
