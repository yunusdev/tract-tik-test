<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Employee;
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
            $limit = $request->get('limit') ?? 10;
            $employees = $this->employeeRepository->fetch($request->get('provider'), $limit);

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

    public function get(int $employeeId): JsonResponse
    {
        try {
            $employee = $this->employeeRepository->get($employeeId);

            return $this->returnSuccess(
                'Employee fetched successfully.',
                Response::HTTP_OK,
                [
                    'employee' => $employee
                ]
            );
        } catch (Exception $exception) {
            return $this->returnError($exception->getMessage(), $exception->getCode());
        }
    }
    public function store(string $provider, EmployeeStoreRequest $request): JsonResponse
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

    public function update(string $provider, EmployeeUpdateRequest $request, $trackTikEmployeeId): JsonResponse
    {
        try {
            $employee = $this->employeeRepository->updateEmployee($provider, $trackTikEmployeeId, $request->all());

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
