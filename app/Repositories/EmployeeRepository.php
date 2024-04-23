<?php


namespace App\Repositories;
use App\Contracts\EmployeeContract;

class EmployeeRepository implements EmployeeContract
{

    public function createEmployee(string $provider, array $data){

        return $data;
    }

}
