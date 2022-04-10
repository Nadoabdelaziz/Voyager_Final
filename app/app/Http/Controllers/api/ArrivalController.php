<?php

namespace App\Http\Controllers\Api;

use App\Models\Arrival;
use App\Models\Source;

use Illuminate\Http\Request;

use Orion\Concerns\DisableAuthorization;

use Illuminate\Database\Eloquent\Builder;

use Orion\Http\Controllers\Controller as OrionController;


class ArrivalController extends OrionController
{
    use DisableAuthorization;

    protected $model = Arrival::class;  
    // or "App\Models\Post"

   /**
     * Builds Eloquent query for fetching entities in index method.
     *
     * @param Request $request
     * @param array $requestedRelations
     * @return Builder
     */
    protected function buildIndexFetchQuery(Request $request, array $requestedRelations): Builder
    {
        $query = parent::buildIndexFetchQuery($request, $requestedRelations);

        $query->where('id',215);

        return $query;
    }
}