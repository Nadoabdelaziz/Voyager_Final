<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Packwindow;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class PackwindowController extends OrionController
{
    use DisableAuthorization;

    protected $model = Packwindow::class;  
    // or "App\Models\Post"
    
}
