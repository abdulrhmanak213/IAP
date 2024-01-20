<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class WhereHas implements Criteria
{
    private $relation , $function;

    public function __construct($relation ,$function = null)
    {
        $this->relation = $relation;
        $this->function = $function;
    }

    public function apply($model)
    {
        return $model->whereHas($this->relation,$this->function);
    }
}
