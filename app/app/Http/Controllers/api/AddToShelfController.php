<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use App\Models\AddToShelf;


use Orion\Concerns\DisableAuthorization;


use Orion\Http\Controllers\Controller as OrionController;

class AddToShelfController extends OrionController
{
    use DisableAuthorization;

    protected $model = AddToShelf::class;  
    // or "App\Models\Post"


}
