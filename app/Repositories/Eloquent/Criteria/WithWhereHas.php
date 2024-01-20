<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class WithWhereHas implements Criteria
{

    private $relation, $function;

    public function __construct($relation, $function = null)
    {
        $this->relation = $relation;
        $this->function = $function;
    }

    public function apply($model)
    {
        return $model->withWhereHas($this->relation, $this->function);
    }
}
