<?php

namespace Tests\Feature;

use App\Services\TrackTickApiService;
use Tests\TestCase;

class EmployeesFetchTest extends TestCase
{
    public function test_success_when_fetching_employees()
    {
        $mockedResponse = [
            "meta" => [
                "count" => 1,
                "request" => [
                    "employees"
                ],
                "itemCount" => 1,
                "security" => [
                    "granted" => true,
                    "requested" => "admin:employees:view",
                    "grantedBy" => "admin:*",
                    "scope" => "core:entities:employees:read"
                ],
                "debug" => null,
                "resource" => "employees",
                "limit" => 100,
                "offset" => 0
            ],
            "data" => [
                [
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
            ]
        ];
        $trackTickApiServiceMock = $this->mock(TrackTickApiService::class);
        $trackTickApiServiceMock->shouldReceive('fetchEmployees')
            ->andReturn($mockedResponse);

        $response = $this->get('api/employees');

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Employees fetched successfully.',
            'data' => [
                'employees' => $mockedResponse
            ],
        ]);
    }

    public function test_failure_when_track_tik_is_not_authenticated_when_fetching_all_employees(): void
    {
        $response = $this->get("api/employees");
        $response->assertStatus(401);

        $this->assertFalse($response->json('success'));
    }

}
