<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class WhereTranslationLike implements Criteria
{

    public function __construct($field, $value)
    {
        $this->value = $value;
        $this->field = $field;
    }

    public function apply($model)
    {
        $model->whereTranslationLike($this->field, '%' . $this->value . '%');
    }
}
