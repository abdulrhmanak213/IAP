<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class With implements Criteria
{

    private $relations;

    public function __construct($relations)
    {
        $this->relations = $relations;
    }

    public function apply($model)
    {
        return $model->with($this->relations);
    }
}
