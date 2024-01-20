<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class Select implements Criteria
{
    private $keys;

    public function __construct($keys)
    {
        $this->keys = $keys;
    }

    public function apply($model)
    {
        return $model->select($this->keys);
    }
}
