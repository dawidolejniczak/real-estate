<?php

namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

final class GoogleMapsService
{
    /**
     * @param string $address
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCoordinates(string $address): array
    {
        try {
            $client = new Client();
            $response = $client->request('GET',
                'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address
                . '&key=' . env('GOOGLE_MAPS_API'));

            $results = json_decode($response->getBody())->results;

            if (!$results) {
                throw new \Exception('Address does not exists');
            }

            $location = $results[0]->geometry->location;

            return [$location->lat, $location->lng];

        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return [0, 0];
        }
    }
}