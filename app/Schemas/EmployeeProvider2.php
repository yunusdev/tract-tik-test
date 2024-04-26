<?php

namespace App\Schemas;

class EmployeeProvider2
{
    public static string $providerName = 'provider2';

    public static function mapTrackTikAttributes($data): array
    {
        return [
            'firstName' => $data['first_name'],
            'lastName' => $data['last_name'],
            'primaryPhone' => $data['phone'],
            'jobTitle' => $data['job_title'],
        ];
    }

    public static function getCreateValidationRules(): array
    {
        return [
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'phone' => ['required','string'],
            'job_title' => ['required','string'],
        ];
    }
    public static function getUpdateValidationRules(): array
    {
        return [
            'first_name' => ['required','string'],
            'last_name' => ['required','string'],
            'phone' => ['required','string'],
            'job_title' => ['required','string'],
        ];
    }
}
