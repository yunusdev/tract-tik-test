<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeesFetchTest extends TestCase
{
    use RefreshDatabase;
    public function test_employees_data_when_fetching_employees(): void
    {

        $provider1Employee = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'provider' => 'provider1',
            'track_tik_id' => '2494'
        ];
        $provider2Employee = [
            'first_name' => 'Adam',
            'last_name' => 'Steven',
            'job_title' => 'PHP Developer',
            'phone' => '+74 3331 3822',
            'provider' => 'provider2',
            'track_tik_id' => '3489'
        ];
        Employee::factory()->provider1()->create($provider1Employee);
        Employee::factory()->provider2()->create($provider2Employee);

        $this->get('api/employees')
                ->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Employees fetched successfully.',
                    'data' => [
                        'employees' => [
                            'items' => [
                                $provider1Employee,
                                $provider2Employee,
                            ],
                            'pagination' => [
                                'total' => 2,
                                'count' => 2,
                                'per_page' => 10,
                                'current_page' => 1,
                                'total_pages' => 1,
                            ]
                        ]
                    ],
                ]);
    }
    public function test_employees_data_when_fetching_provider1_employees() : void
    {

        $provider1Employee = [
            'email' => 'john@gmail.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'provider' => 'provider1',
            'track_tik_id' => '2494'
        ];

        Employee::factory()->provider1()->create($provider1Employee);
        Employee::factory(3)->provider2()->create();

        $this->get('api/employees?provider=provider1')
                ->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Employees fetched successfully.',
                    'data' => [
                        'employees' => [
                            'items' => [
                                $provider1Employee,
                            ],
                            'pagination' => [
                                'total' => 1,
                                'count' => 1,
                                'per_page' => 10,
                                'current_page' => 1,
                                'total_pages' => 1,
                            ]
                        ]
                    ],
                ]);
    }
    public function test_employees_data_when_fetching_provider2_employees() : void
    {

        $provider2Employee = [
            'first_name' => 'Adam',
            'last_name' => 'Steven',
            'job_title' => 'PHP Developer',
            'phone' => '+74 3331 3822',
            'provider' => 'provider2',
            'track_tik_id' => '2494'
        ];
        Employee::factory(5)->provider1()->create();
        Employee::factory()->provider2()->create($provider2Employee);

        $this->get('api/employees?provider=provider2')
                ->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Employees fetched successfully.',
                    'data' => [
                        'employees' => [
                            'items' => [
                                $provider2Employee,
                            ],
                            'pagination' => [
                                'total' => 1,
                                'count' => 1,
                                'per_page' => 10,
                                'current_page' => 1,
                                'total_pages' => 1,
                            ]
                        ]
                    ],
                ]);
    }


}
