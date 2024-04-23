<?php

namespace App\Contracts;

interface EmployeeContract
{
    public function createEmployee(string $provider, array $data);

}
