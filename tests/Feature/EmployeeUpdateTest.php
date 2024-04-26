<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Services\TrackTickApiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeUpdateTest extends TestCase
{
    use RefreshDatabase;
    public function test_success_when_updating_employee()
    {
        $trackTikEmployeeId = 3064;

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

        $requestData = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $response = $this->put("api/provider1/employees/{$trackTikEmployeeId}", $requestData);

        $response->assertStatus(200);

        $requestData['track_tik_id'] = $trackTikEmployeeId;

        $response->assertJson([
            'success' => true,
            'message' => 'Employee updated successfully.',
            'data' => [
                'employee' => $requestData
            ],
        ]);
    }
    public function test_employees_count_after_updating_an_employee_that_doesnt_have_a_db_record()
    {
        $this->assertSame(0, Employee::query()->count());

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

        $this->put('api/provider2/employees/3064', [
            'first_name' => 'Adam',
            'last_name' => 'Steven',
            'job_title' => 'PHP Developer',
            'phone' => '+74 3331 3822'
        ])->assertStatus(200);

        $this->assertSame(1, Employee::query()->count());
    }
    public function test_employees_count_after_updating_an_employee_that_has_a_db_record()
    {
        $trackTikEmployeeId = 3064;

        Employee::factory()->provider1()->trackTikId($trackTikEmployeeId)->create();

        $this->assertSame(1, Employee::query()->count());

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

        $requestData = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $this->put("api/provider1/employees/{$trackTikEmployeeId}", $requestData)
            ->assertStatus(200);

        $this->assertSame(1, Employee::query()->count());
    }
    public function test_employee_data_after_updating_an_employee_that_has_a_db_record_for_provider1()
    {
        $trackTikEmployeeId = 3064;

        Employee::factory()->provider1()->trackTikId($trackTikEmployeeId)->create();

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
                "primaryPhone" => "+74 3331 3822",
                "secondaryPhone" => "",
                "email" => "",
                "status" => "ACTIVE",
                "avatar" => "https://smoke.staffr.net/rest/v1/avatar/employees/3066/4bab77d25280094b20dc81632fec07d9"
            ]
        ];
        $trackTickApiServiceMock = $this->mock(TrackTickApiService::class);
        $trackTickApiServiceMock->shouldReceive('updateEmployee')
            ->andReturn($mockedResponse);

        $requestData = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $this->put("api/provider1/employees/{$trackTikEmployeeId}", $requestData)
            ->assertStatus(200);

        $employee = Employee::query()->first();

        $this->assertSame($requestData['email'], $employee->email);
        $this->assertSame($requestData['first_name'], $employee->first_name);
        $this->assertSame($requestData['last_name'], $employee->last_name);
        $this->assertSame($trackTikEmployeeId, $employee->track_tik_id);
        $this->assertNull($employee->job_title);
        $this->assertNull($employee->phone);
    }
    public function test_employee_data_after_updating_an_employee_that_has_a_db_record_for_provider2()
    {
        $trackTikEmployeeId = 3064;

        Employee::factory()->provider2()->trackTikId($trackTikEmployeeId)->create();

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
                "primaryPhone" => "+74 3331 3822",
                "secondaryPhone" => "",
                "email" => "",
                "status" => "ACTIVE",
                "avatar" => "https://smoke.staffr.net/rest/v1/avatar/employees/3066/4bab77d25280094b20dc81632fec07d9"
            ]
        ];
        $trackTickApiServiceMock = $this->mock(TrackTickApiService::class);
        $trackTickApiServiceMock->shouldReceive('updateEmployee')
            ->andReturn($mockedResponse);

        $requestData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'job_title' => 'PHP Developer',
            'phone' => '+74 3331 3822'
        ];

        $this->put("api/provider2/employees/{$trackTikEmployeeId}", $requestData)
                ->assertStatus(200);

        $employee = Employee::query()->first();

        $this->assertSame($requestData['first_name'], $employee->first_name);
        $this->assertSame($requestData['last_name'], $employee->last_name);
        $this->assertSame($requestData['job_title'], $employee->job_title);
        $this->assertSame($requestData['phone'], $employee->phone);
        $this->assertSame($trackTikEmployeeId, $employee->track_tik_id);
        $this->assertNull($employee->email);
    }
    public function test_for_error_when_trying_to_update_another_provider_employee()
    {
        $trackTikEmployeeId = 3064;

        $employeeFactory = Employee::factory()->provider2()->trackTikId($trackTikEmployeeId)->create();

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
                "primaryPhone" => "+74 3331 3822",
                "secondaryPhone" => "",
                "email" => "",
                "status" => "ACTIVE",
                "avatar" => "https://smoke.staffr.net/rest/v1/avatar/employees/3066/4bab77d25280094b20dc81632fec07d9"
            ]
        ];
        $trackTickApiServiceMock = $this->mock(TrackTickApiService::class);
        $trackTickApiServiceMock->shouldReceive('updateEmployee')
            ->andReturn($mockedResponse);

        $requestData = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $this->put("api/provider1/employees/{$trackTikEmployeeId}", $requestData)
                ->assertStatus(400)
                ->assertJson([
                    'success' => false,
                    'message' => 'This provider cant update the employee with the Track Tick ID.',
                ]);

        $employee = Employee::query()->first();

        $this->assertSame($employeeFactory['first_name'], $employee->first_name);
        $this->assertSame($employeeFactory['last_name'], $employee->last_name);
        $this->assertSame($employeeFactory['job_title'], $employee->job_title);
        $this->assertSame($employeeFactory['phone'], $employee->phone);
        $this->assertSame($trackTikEmployeeId, $employee->track_tik_id);
        $this->assertNull($employee->email);
    }

    /**
     * @dataProvider data
     */
    public function test_validation_errors_when_updating_employee($providerName, $employeeId, $status, $requestData, $errorAttributes): void
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
            ['provider1', 3061, 401, [
                'email' => 'adam@gmail.com',
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
