<?php

namespace Feature;

use App\Services\TrackTickApiService;
use Tests\TestCase;

class EmployeeUpdateTest extends TestCase
{
    public function test_success_when_updating_employee()
    {
        $mockedResponse = [
            "meta" => [
                "request" => [
                    "employees",
                    "3064"
                ],
                "security" => [
                    "granted" => true,
                    "requested" => "admin:employees:view",
                    "grantedBy" => "admin:*",
                    "scope" => "core:entities:employees:read"
                ],
                "debug" => null,
                "resource" => "employees"
            ],
            "data" => [
                "jobTitle" => "PHP Developer",
                "region" => 1914,
                "employmentProfile" => 1920,
                "address" => 15410,
                "id" => 3064,
                "customId" => "3064",
                "firstName" => "John",
                "lastName" => "Doe",
                "name" => "John Doe",
                "primaryPhone" => "",
                "secondaryPhone" => "",
                "email" => "john@gmail.com",
                "status" => "ACTIVE",
                "avatar" => "https://smoke.staffr.net/rest/v1/avatar/employees/3066/4bab77d25280094b20dc81632fec07d9"
            ]
        ];
        $trackTickApiServiceMock = $this->mock(TrackTickApiService::class);
        $trackTickApiServiceMock->shouldReceive('updateEmployee')
            ->andReturn($mockedResponse);

        $response = $this->put('api/provider1/employees/3064', [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Employee updated successfully.',
            'data' => [
                'employee' => $mockedResponse
            ],
        ]);
    }

    /**
     * @dataProvider data
     */
    public function test_failure_when_updating_employee($providerName, $employeeId, $status, $requestData, $errorAttributes): void
    {
        $response = $this->put("api/{$providerName}/employees/{$employeeId}", $requestData);
        $response->assertStatus($status);

        $boolStatus = $response->json('success');
        $this->assertFalse($boolStatus);

        $data = $response->json('data');
        if($data === null || !isset($data['errors'])) return;

        $actualErrorAttributes = array_keys($data['errors']);
        sort($actualErrorAttributes);
        sort($errorAttributes);

        $this->assertEquals($actualErrorAttributes, $errorAttributes);

    }

    public static function data() : array
    {
        return [

            ['wrong_provider', 345, 404, [], []],

            ['provider1', 'invalid_employee_id', 404, [], []],

            ['provider1', 3061, 422,  [], ['email', 'first_name', 'last_name']],
            ['provider1', 3061, 422, [
                'email' => 'adam@gmail.com',
                'first_name' => 'Adam'
            ], ['last_name']],
            ['provider1', 3061, 422, [
                'email' => 'adam@gmail.com'
            ], ['first_name', 'last_name']],
            ['provider1', 3061, 422, [
                'email' => 'invalid',
                'first_name' => 'Adam',
                'last_name' => 'Steven'
            ], ['email']],

            ['provider2', 3061, 422, [], ['first_name', 'last_name', 'phone', 'job_title']],
            ['provider2', 3061, 422, [
                'first_name' => 'Adam',
                'last_name' => 'Steven'
            ], ['phone', 'job_title']],
            ['provider2', 3061, 422, [
                'first_name' => 'Adam',
                'last_name' => 'Steven',
                'job_title' => 'PHP Developer'
            ], ['phone']],

        ];
    }
}
