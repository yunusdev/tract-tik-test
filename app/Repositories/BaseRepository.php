<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseContract
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function store(array $attributes): mixed
    {
        return $this->model->create($attributes);
    }

    public function find(string $id): mixed
    {
        return $this->model->find($id);
    }

    public function updateOrCreate(array $filter, array $attributes)
    {
        return $this->model->updateOrCreate($attributes, $filter);
    }

    public function paginate(array $filters = [], int $numPaginated = 10, string $orderBy = 'created_at', string $sortBy = 'desc'): mixed
    {
        return $this->model->where($filters)->orderBy($orderBy, $sortBy)->paginate($numPaginated ?? 10);
    }

    public function findOneBy(array $filter)
    {
        return $this->model->where($filter)->first();
    }

}
