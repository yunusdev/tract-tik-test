<?php

namespace App\Http\Requests;

use App\Schemas\EmployeeProvider1;
use App\Schemas\EmployeeProvider2;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $providerRules = [
//            'provider' => ['required', Rule::in([EmployeeProvider1::$providerName, EmployeeProvider2::$providerName])],
        ];
        $provider = $this->route('provider');

        $mappingRules = match ($provider) {
            EmployeeProvider1::$providerName => EmployeeProvider1::getValidationRules(),
            EmployeeProvider2::$providerName => EmployeeProvider2::getValidationRules(),
        };

        return array_merge($providerRules, $mappingRules);
    }

}
