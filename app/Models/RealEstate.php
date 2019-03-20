<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class RealEstate extends Model
{
    /**
     * @var array
     */
    public static $rules = [
        'address_line_1' => 'required|string|max:255',
        'address_line_2' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'postcode' => 'required|string',
    ];

    protected $fillable = [
        'address_line_1', 'address_line_2', 'city', 'postcode', 'lat', 'lng'
    ];
}
