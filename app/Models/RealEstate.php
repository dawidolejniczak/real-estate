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
        'address_line_2' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'postcode' => 'required|string',
    ];

    protected $fillable = [
        'name', 'address', 'phone_number', 'email_address', 'city_id', 'students_count'
    ];
}
