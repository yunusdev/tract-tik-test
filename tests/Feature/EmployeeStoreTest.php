<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Services\TrackTickApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeStoreTest extends TestCase
{
    use RefreshDatabase;
    public function test_success_when_creating_employee()
    {
        $trackTikEmployeeId = 3098;

        $mockedResponse = [
            "meta" => [
                "request" => [
                    "employees"
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
                "id" => $trackTikEmployeeId,
                "customId" => "3098",
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
        $trackTickApiServiceMock->shouldReceive('storeEmployee')
            ->andReturn($mockedResponse);

        $requestData = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $response = $this->post('api/provider1/employees', $requestData);

        $response->assertStatus(201);

        $requestData['track_tik_id'] = $trackTikEmployeeId;

        $response->assertJson([
            'success' => true,
            'message' => 'Employee created successfully.',
            'data' => [
                'employee' => $requestData
            ],
        ]);
    }
    public function test_employees_count_after_creating_an_employee()
    {
        $trackTikEmployeeId = 3098;

        $this->assertSame(0, Employee::query()->count());

        $mockedResponse = [
            "meta" => [
                "request" => [
                    "employees"
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
                "id" => $trackTikEmployeeId,
                "customId" => "3098",
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
        $trackTickApiServiceMock->shouldReceive('storeEmployee')
            ->andReturn($mockedResponse);

        $requestData = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $this->post('api/provider1/employees', $requestData);

        $this->assertSame(1, Employee::query()->count());
    }
    public function test_employees_data_after_creating_an_employee_for_provider1()
    {
        $trackTikEmployeeId = 3098;

        $mockedResponse = [
            "meta" => [
                "request" => [
                    "employees"
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
                "id" => $trackTikEmployeeId,
                "customId" => "3098",
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
        $trackTickApiServiceMock->shouldReceive('storeEmployee')
            ->andReturn($mockedResponse);

        $requestData = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $this->post('api/provider1/employees', $requestData);

        $employee = Employee::query()->first();

        $this->assertSame($requestData['email'], $employee->email);
        $this->assertSame($requestData['first_name'], $employee->first_name);
        $this->assertSame($requestData['last_name'], $employee->last_name);
        $this->assertSame($trackTikEmployeeId, $employee->track_tik_id);
        $this->assertNull($employee->job_title);
        $this->assertNull($employee->phone);
    }
    public function test_employees_data_after_creating_an_employee_for_provider2()
    {
        $trackTikEmployeeId = 3098;

        $mockedResponse = [
            "meta" => [
                "request" => [
                    "employees"
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
                "id" => $trackTikEmployeeId,
                "customId" => "3098",
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
        $trackTickApiServiceMock->shouldReceive('storeEmployee')
            ->andReturn($mockedResponse);

        $requestData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'job_title' => 'PHP Developer',
            'phone' => '+74 3331 3822'
        ];

        $this->post('api/provider2/employees', $requestData);

        $employee = Employee::query()->first();

        $this->assertSame($requestData['first_name'], $employee->first_name);
        $this->assertSame($requestData['last_name'], $employee->last_name);
        $this->assertSame($requestData['job_title'], $employee->job_title);
        $this->assertSame($requestData['phone'], $employee->phone);
        $this->assertSame($trackTikEmployeeId, $employee->track_tik_id);
        $this->assertNull($employee->email);
    }

    /**
     * @dataProvider data
     */
    public function test_validation_errors_when_creating_employee($providerName, $status, $requestData, $errorAttributes): void
    {
        $response = $this->post("api/{$providerName}/employees", $requestData);
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

            ['wrong_provider', 404, [], []],

            ['provider1', 422, [], ['email', 'first_name', 'last_name']],
            ['provider1', 422, [
                'email' => 'adam@gmail.com',
                'first_name' => 'Adam'
            ], ['last_name']],
            ['provider1', 422, [
                'email' => 'adam@gmail.com'
            ], ['first_name', 'last_name']],
            ['provider1', 422, [
                'email' => 'invalid',
                'first_name' => 'Adam',
                'last_name' => 'Steven'
            ], ['email']],
            ['provider1', 401, [
                'email' => 'adam@gmail.com',
                'first_name' => 'Adam',
                'last_name' => 'Steven'
            ], []],

            ['provider2', 422, [], ['first_name', 'last_name', 'phone', 'job_title']],
            ['provider2', 422, [
                'first_name' => 'Adam',
                'last_name' => 'Steven'
            ], ['phone', 'job_title']],
            ['provider2', 422, [
                'first_name' => 'Adam',
                'last_name' => 'Steven',
                'job_title' => 'PHP Developer'
            ], ['phone']],

        ];
    }
}
