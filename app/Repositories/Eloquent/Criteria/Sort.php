<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\Criteria;

class Sort implements Criteria
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    /**
     * @var string
     */
    private $sort;

    /**
     * @var string
     */
    private $order;

    /**
     * @param $sort
     * @param string $order
     */
    public function __construct($sort, $order = self::DESC)
    {
        $this->sort = $sort;
        $this->order = $order;
    }

    public function apply($model)
    {
        return $model->orderBy($this->sort, $this->order);
    }
}
