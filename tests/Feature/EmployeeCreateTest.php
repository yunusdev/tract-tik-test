<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeCreateTest extends TestCase
{
    /**
     * @dataProvider data
     */
    public function test_failed_employee_create($providerName, $status, $requestData, $errorAttributes): void
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

            ['provider2', 422, [], ['first_name', 'last_name', 'phone', 'username']],
            ['provider2', 422, [
                'first_name' => 'Adam',
                'last_name' => 'Steven'
            ], ['phone', 'username']],
            ['provider2', 422, [
                'first_name' => 'Adam',
                'last_name' => 'Steven',
                'username' => 'adamsteve'
            ], ['phone']],

        ];
    }
}
