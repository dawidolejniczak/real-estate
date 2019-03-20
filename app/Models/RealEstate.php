<?php

namespace App\Models;

use App\Services\GoogleMapsService;
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
        'address_line_1', 'address_line_2', 'city', 'postcode'
    ];

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCoordinates(): array
    {
        $googleMaps = new GoogleMapsService();

        return $googleMaps->getCoordinates(
            $this->address_line_1 . ', ' .
            $this->address_line_2 . ', ' .
            $this->city . ', ' .
            $this->postcode . ', '
        );
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function assignCoordinates(): void
    {
        $coordinates = $this->getCoordinates();

        $this->setAttribute('lat', $coordinates[0]);
        $this->setAttribute('lng', $coordinates[1]);
    }
}
