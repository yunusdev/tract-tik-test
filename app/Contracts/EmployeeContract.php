<?php

namespace App\Contracts;

interface EmployeeContract
{
    public function storeEmployee(string $provider, array $data);

}
