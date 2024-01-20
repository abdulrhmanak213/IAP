<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class WhereIn implements Criteria
{
    private $field, $value;

    public function __construct($field, $value)
    {
        $this->value = $value;
        $this->field = $field;
    }

    public function apply($model)
    {
        return $model->whereIn($this->field,$this->value);
    }
}
