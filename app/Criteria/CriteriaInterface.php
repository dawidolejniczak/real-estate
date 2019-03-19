<?php

namespace App\Criteria;

use Illuminate\Database\Eloquent\Builder;

interface CriteriaInterface
{
    /**
     * @param Builder $model
     * @param mixed ...$params
     * @return Builder
     */
    public function apply(Builder $model, ...$params): Builder;
}
