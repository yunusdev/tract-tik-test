<?php
namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseContract
{
    /**
     * Create a model instance
     *
     * @param  array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param array $attributes
     * @param string $id
     * @return bool
     */
    public function update(array $attributes, string $id) : bool;

}
