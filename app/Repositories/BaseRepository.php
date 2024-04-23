<?php

namespace App\Repositories;

use App\Contracts\BaseContract;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseContract
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param  array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param string $id
     * @return bool
     */
    public function update(array $attributes, string $id) : bool
    {
        return $this->find($id)->update($attributes);
    }

}
