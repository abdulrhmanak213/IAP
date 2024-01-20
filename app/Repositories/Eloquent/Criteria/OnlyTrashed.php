<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class OnlyTrashed implements Criteria
{
    public function apply($model)
    {
        return $model->onlyTrashed();
    }
}
