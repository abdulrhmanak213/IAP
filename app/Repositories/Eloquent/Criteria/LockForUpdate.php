<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class LockForUpdate implements Criteria
{


    public function apply($model)
    {
        return $model->lockForUpdate();
    }
}
