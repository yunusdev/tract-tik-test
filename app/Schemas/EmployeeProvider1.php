<?php

namespace App\Schemas;

class EmployeeProvider1
{
    public static $providerName = 'provider1';

    public static function mapAttributes($data)
    {
        return [
            'email' => $data['email'],
            'firstName' => $data['first_name'],
            'lastName' => $data['last_name'],
        ];
    }

    public static function getValidationRules()
    {
        return [
            'email' => 'required|email',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ];
    }
}
