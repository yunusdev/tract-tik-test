<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreUpdateRequest;
use App\Repositories\EmployeeRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{

    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $employees = $this->employeeRepository->fetch($request->get('provider'));

            return $this->returnSuccess(
                'Employees fetched successfully.',
                Response::HTTP_OK,
                [
                    'employees' => $employees
                ]
            );
        } catch (Exception $exception) {
            return $this->returnError($exception->getMessage(), $exception->getCode());
        }
    }
    public function store($provider, EmployeeStoreUpdateRequest $request): JsonResponse
    {
        try {
            $employee = $this->employeeRepository->store($provider, $request->all());

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

    public function update($provider, EmployeeStoreUpdateRequest $request, $employeeId): JsonResponse
    {
        try {
            $employee = $this->employeeRepository->update($provider, $employeeId, $request->all());

            return $this->returnSuccess(
                'Employee updated successfully.',
                Response::HTTP_OK,
                [
                    'employee' => $employee
                ]
            );
        } catch (Exception $exception) {
            return $this->returnError($exception->getMessage(), $exception->getCode());
        }
    }

}
