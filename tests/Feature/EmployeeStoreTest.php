<?php

namespace Tests\Feature;

use App\Services\TrackTickApiService;
use Tests\TestCase;

class EmployeeStoreTest extends TestCase
{
    public function test_success_when_creating_employee()
    {
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
                "id" => 3098,
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

        $response = $this->post('api/provider1/employees', [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe'
        ]);

        $response->assertStatus(201);

        $response->assertJson([
            'message' => 'Employee created successfully.',
            'data' => [
                'employee' => $mockedResponse
            ],
        ]);
    }

    /**
     * @dataProvider data
     */
    public function test_failure_when_creating_employee($providerName, $status, $requestData, $errorAttributes): void
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
