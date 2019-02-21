<?php

namespace App\Http\Controllers;

use App\House;
use Spatie\QueryBuilder\Filter;
use App\Http\Resources\HouseResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\GetHousesRequest;

class HouseController extends Controller
{
    public function __invoke(GetHousesRequest $request)
    {
        $houses = QueryBuilder::for(House::class)
            ->allowedFilters(
                'name',
                Filter::scope('price_from'),
                Filter::scope('price_to'),
                Filter::exact('bedrooms'),
                Filter::exact('bathrooms'),
                Filter::exact('storeys'),
                Filter::exact('garages')
            )
            ->allowedSorts(
                'name',
                'price',
                'bedrooms',
                'bathrooms',
                'storeys',
                'garages'
            )
            ->paginate($request->has('per_page') ? $request->get('per_page') : 15);

        $appends = $request->validated();
        $appends['per_page'] = $request->get('per_page');

        $houses->appends($appends)->links();

        return HouseResource::collection($houses);
    }
}
