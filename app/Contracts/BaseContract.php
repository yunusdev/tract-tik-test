<?php
namespace App\Contracts;

interface BaseContract
{
    public function store(array $attributes): mixed;

    public function find(string $id): mixed;

    public function update(int $id, array $attributes): bool;

    public function paginate(
        array $filters = [],
        int $numPaginated = 10,
        string $orderBy = 'created_at',
        string $sortBy = 'desc',
    ): mixed;
    public function findOneBy(array $filter);

}
