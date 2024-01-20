<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class EagerLoadingWithCount implements Criteria
{
    /**
     * @var string|\string[]
     */
    private $relations;

    /**
     * @param string[] $relations
     */
    public function __construct($relations)
    {
        $this->relations = $relations;
    }

    public function apply($model)
    {
        return $model->withCount($this->relations);
    }
}
