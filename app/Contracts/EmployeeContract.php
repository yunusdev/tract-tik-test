<?php

namespace App\Contracts;

interface EmployeeContract
{
    public function fetch(string|null $provider);

    public function store(string $provider, array $data);

    public function update(string $provider, int $employeeId, array $data);

}
