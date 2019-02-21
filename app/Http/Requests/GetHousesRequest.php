<?php

namespace App\Http\Requests;

class GetHousesRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $sort = implode(",", [
            'name',
            '-name',
            'price',
            '-price',
            'bathrooms',
            '-bathrooms',
            'storeys',
            '-storeys',
            'bedrooms',
            '-bedrooms',
            'garages',
            '-garages',
        ]);

        return [
            'filter' => 'array',
            'filter.name' => 'string|nullable',
            'filter.price_from' => 'numeric|nullable|min:0',
            'filter.price_to' => 'numeric|nullable|min:0',
            'filter.bedrooms' => 'numeric|nullable|min:0',
            'filter.bathrooms' => 'numeric|nullable|min:0',
            'filter.storeys' => 'numeric|nullable|min:0',
            'filter.garages' => 'numeric|nullable|min:0',
            'sort' => "string|in:$sort",
        ];
    }
}
