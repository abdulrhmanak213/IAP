<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IBase;
use App\Traits\HttpResponse;
use Illuminate\Support\Arr;

abstract class BaseRepository implements IBase
{
    use HttpResponse;

    protected $model;
    public $languages = ['en', 'de'];

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    protected function getModelClass()
    {
        if (!method_exists($this, 'model')) {
            return self::failure('no model defined', 422);
        }

        return app()->make($this->model());
    }

    public function withCriteria(...$criteria): BaseRepository
    {
        $criteria = Arr::flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }
        return $this;
    }

    public function all()
    {
        return $this->model->latest()->get();
    }

    public function allWithPagination($count = 10)
    {
        return $this->model->latest()->paginate($count);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function first()
    {
        return $this->model->first();
    }

    public function firstOrCreate($data)
    {
        return $this->model->firstOrCreate($data);
    }

    public function firstOrNew($data)
    {
        return $this->model->firstOrNew($data);
    }

    public function firstOrFail()
    {
        return $this->model->firstOrFail();
    }

    public function forceCreate($data)
    {
        return $this->model->forceCreate($data);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function updateInstance($data)
    {
        return $this->model->update($data);
    }

    public function delete($id)
    {
        $record = $this->findOrFail($id);
        return $record->delete();
    }

    public function forceFill($record, array $data)
    {
        return $record->forceFill($data)->save();
    }

    public function restore($id)
    {
        return $this->model->withTrashed()->where('id', $id)->restore();
    }

    public function addMedia($record, $media, $collection = '')
    {
        $record->addMedia($media)->toMediaCollection($collection);
        $record->save();
    }

    public function clearMediaCollection($record, $collection)
    {
        $record->clearMediaCollection($collection);
        $record->save();
    }

    public function eagerLoad($record, $relations)
    {
        return $record->load($relations);
    }

}
