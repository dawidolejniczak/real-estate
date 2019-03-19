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
}