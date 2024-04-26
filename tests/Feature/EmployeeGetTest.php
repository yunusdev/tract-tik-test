<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeGetTest extends TestCase
{
    use RefreshDatabase;
    public function test_success_when_getting_a_provider1_employee()
    {
        $trackTikEmployeeId = 3098;

        $employee = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'provider' => 'provider1'
        ];

        Employee::factory()->trackTikId($trackTikEmployeeId)->create($employee);

        $this->get("api/employees/{$trackTikEmployeeId}")
                ->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Employee fetched successfully.',
                    'data' => [
                        'employee' => $employee
                    ],
                ]);
    }

    public function test_success_when_getting_a_provider2_employee()
    {
        $trackTikEmployeeId = 3098;

        $employee = [
            'first_name' => 'Adam',
            'last_name' => 'Steven',
            'job_title' => 'PHP Developer',
            'phone' => '+74 3331 3822'
        ];

        Employee::factory()->trackTikId($trackTikEmployeeId)->create($employee);

        $this->get("api/employees/{$trackTikEmployeeId}")
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Employee fetched successfully.',
                'data' => [
                    'employee' => $employee
                ],
            ]);
    }

    public function test_failure_when_invalid_employee_id_is_used_when_getting_an_employee(): void
    {
        $response = $this->get("api/employees/invalid");
        $response->assertStatus(404);

        $this->assertFalse($response->json('success'));
    }

}
