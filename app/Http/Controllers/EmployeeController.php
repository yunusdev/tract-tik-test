<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeCreateRequest;
use App\Repositories\EmployeeRepository;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{

    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function store($provider, EmployeeCreateRequest $request): JsonResponse
    {
        try {
            $employee = $this->employeeRepository->storeEmployee($provider, $request->all());

            return $this->returnSuccess(
                'Employee created successfully.',
                Response::HTTP_CREATED,
                [
                    'employee' => $employee
                ]
            );
        } catch (Exception $exception) {
            return $this->returnError($exception->getMessage(), $exception->getCode());
        }
    }


}
