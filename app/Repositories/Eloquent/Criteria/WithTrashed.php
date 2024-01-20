<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class WithTrashed implements Criteria
{
    public function apply($model)
    {
        return $model->withTrashed();
    }
}
