<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class When implements Criteria
{
    private $value, $function;

    public function __construct($value,$function)
    {
        $this->value = $value;
        $this->function = $function;
    }

    public function apply($model)
    {
        return $model->when($this->value, $this->function);
    }
}
