<?php

namespace App\Contracts;

use App\Http\Transformers\EmployeeCollection;

interface EmployeeContract
{
    public function fetch(string|null $provider, int $limit): EmployeeCollection;
    public function get(int $trackTikEmployeeId);
    public function storeEmployee(string $provider, array $data);
    public function updateEmployee(string $provider, int $trackTikEmployeeId, array $data);

}
