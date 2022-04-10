<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Strorage;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class StrorageController extends OrionController
{
    use DisableAuthorization;

    protected $model = Strorage::class;  
    // or "App\Models\Post"
    
}
