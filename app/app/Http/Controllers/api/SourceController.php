<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Source;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class SourceController extends OrionController
{
    use DisableAuthorization;

    protected $model = Source::class;  
    // or "App\Models\Post"
    
}
