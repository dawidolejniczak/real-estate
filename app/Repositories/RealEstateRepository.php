<?php
/**
 * Created by PhpStorm.
 * User: dawid
 * Date: 19/03/2019
 * Time: 21:09
 */

namespace App\Repositories;


use App\Extensions\AbstractRepository;
use App\Models\RealEstate;
use App\Services\GoogleMapsService;
use Illuminate\Database\Eloquent\Builder;

final class RealEstateRepository extends AbstractRepository
{
    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return RealEstate::query();
    }

    /**
     * @param array $data
     * @return Builder|\Illuminate\Database\Eloquent\Model
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $data)
    {
        $googleMap = new GoogleMapsService();
        $coordinates = $googleMap->getCoordinates(
            $data['address_line_1'] . ', ' .
            $data['address_line_2'] . ', ' .
            $data['city'] . ', ' .
            $data['postcode']
        );

        $data['lat'] = $coordinates[0];
        $data['lng'] = $coordinates[1];

        $school = $this->query->create($data);
        $this->reset();

        return $school;
    }
}