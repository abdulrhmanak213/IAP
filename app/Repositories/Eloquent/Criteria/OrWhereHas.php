<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class OrWhereHas implements Criteria
{
    private $relation, $function;

    public function __construct($relation, $function = null)
    {
        $this->relation = $relation;
        $this->function = $function;
    }

    public function apply($model)
    {
        return $model->orWhereHas($this->relation, $this->function);
    }
}
