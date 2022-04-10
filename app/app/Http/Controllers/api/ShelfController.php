<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Shelf;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class ShelfController extends OrionController
{
    use DisableAuthorization;

    protected $model = Shelf::class;  
    // or "App\Models\Post"
    
}
