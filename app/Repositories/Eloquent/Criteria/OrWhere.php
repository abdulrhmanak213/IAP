<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class OrWhere implements Criteria
{
    private $value, $field, $operation;

    public function __construct($field, $value, $operation = 'like')
    {
        $this->value = $value;
        $this->operation = $operation;
        $this->field = $field;
    }

    public function apply($model)
    {
        return $model->orWhere($this->field, $this->operation, $this->value);
    }
}
