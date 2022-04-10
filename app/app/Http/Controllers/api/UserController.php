<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;

use Orion\Concerns\DisableAuthorization;

use Orion\Http\Controllers\Controller as OrionController;

class UserController extends OrionController
{
    use DisableAuthorization;

    protected $model = User::class;  
    // or "App\Models\Post"


}
