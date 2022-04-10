<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use App\Models\NewRow;


use Orion\Concerns\DisableAuthorization;


use Orion\Http\Controllers\Controller as OrionController;

class NewRowController extends OrionController
{
    use DisableAuthorization;

    protected $model = NewRow::class;  
    // or "App\Models\Post"


}
