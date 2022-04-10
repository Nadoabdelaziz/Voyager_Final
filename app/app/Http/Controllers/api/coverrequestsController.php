<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;


use App\Models\Coverrequest;


use Orion\Concerns\DisableAuthorization;


use Orion\Http\Controllers\Controller as OrionController;

class coverrequestsController extends OrionController
{
    use DisableAuthorization;

    protected $model = Coverrequest::class;  
    // or "App\Models\Post"


}
