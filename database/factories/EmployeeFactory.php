<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{

    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'track_tik_id' => $this->faker->randomNumber(4),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'provider' => $this->faker->randomElement(['provider1', 'provider2']),
        ];
    }

    public function provider1()
    {
        return $this->state(function () {
            return [
                'email' => $this->faker->email(),
            ];
        });
    }

    public function provider2()
    {
        return $this->state(function () {
            return [
                'phone' => $this->faker->phoneNumber(),
                'job_title' => $this->faker->jobTitle(),
            ];
        });
    }

    public function trackTikId(int $trackTikEmployeeId)
    {
        return $this->state(function () use ($trackTikEmployeeId){
            return [
                'track_tik_id' => $trackTikEmployeeId,
            ];
        });
    }
}
