<?php

namespace Tests\Feature;

use App\Services\TrackTickApiService;
use Tests\TestCase;

class EmployeeGetTest extends TestCase
{
    public function test_success_when_getting_an_employee()
    {
        $mockedResponse = [
            "meta" => [
                "request" => [
                    "employees",
                    "3098"
                ],
                "security" => [
                    "granted" => true,
                    "requested" => "admin:employees:view",
                    "grantedBy" => "admin:*",
                    "scope" => "core:entities:employees:read"
                ],
                "debug" => null,
                "resource" => "employees",
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
        $trackTickApiServiceMock->shouldReceive('getEmployee')
            ->andReturn($mockedResponse);

        $response = $this->get('api/employees/3098');

        $response->assertStatus(200);

        $response->assertJson([
            'message' => 'Employee fetched successfully.',
            'data' => [
                'employee' => $mockedResponse
            ],
        ]);
    }

    public function test_failure_when_invalid_employee_is_used_when_getting_an_employee(): void
    {
        $response = $this->get("api/employees/invalid");
        $response->assertStatus(404);

        $this->assertFalse($response->json('success'));
    }

    public function test_failure_when_track_tik_is_not_authenticated_when_getting_an_employee(): void
    {
        $response = $this->get("api/employees/4052");
        $response->assertStatus(401);

        $this->assertFalse($response->json('success'));
    }

}
