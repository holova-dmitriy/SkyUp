<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class House extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages',
    ];

    public function scopePriceFrom(Builder $query, $price)
    {
        $query->where('price', '>=', $price);
    }

    public function scopePriceTo(Builder $query, $price)
    {
        $query->where('price', '<=', $price);
    }
}
