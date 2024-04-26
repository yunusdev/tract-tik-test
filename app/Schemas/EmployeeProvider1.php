<?php

namespace App\Schemas;

class EmployeeProvider1 extends BaseEmployeeProvider
{
    public static string $providerName = 'provider1';

    public static function mapTrackTikAttributes($data): array
    {
        return [
            'email' => $data['email'],
            'firstName' => $data['first_name'],
            'lastName' => $data['last_name'],
        ];
    }

    public static function getCreateValidationRules(): array
    {
        return [
            'email' => ['required','email', 'unique:employees'],
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
        ];
    }
    public static function getUpdateValidationRules(): array
    {
        return [
            'email' => ['required','email'],
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
        ];
    }
}
