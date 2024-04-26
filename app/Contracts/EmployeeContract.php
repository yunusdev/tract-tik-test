<?php

namespace App\Contracts;

interface EmployeeContract
{
    public function fetch(string|null $provider);
    public function get(int $employeeId);
    public function storeEmployee(string $provider, array $data);
    public function updateEmployee(string $provider, int $trackTikEmployeeId, array $data);

}
