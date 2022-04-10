<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Secondcover;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class SecondcoversController extends OrionController
{
    use DisableAuthorization;

    protected $model = Secondcover::class;  
    // or "App\Models\Post"
    
}
