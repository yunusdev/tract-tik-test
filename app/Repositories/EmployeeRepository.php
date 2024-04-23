<?php


namespace App\Repositories;
use App\Contracts\EmployeeContract;

class EmployeeRepository extends BaseRepository implements EmployeeContract
{

    /**
     * EmployeeRepository constructor.
     */
    public function __construct(Achievement $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }


    public function createEmployee(string $group, int $number){

        return $this->findOneBy(['group' => $group, 'number' => $number]);

    }

}
