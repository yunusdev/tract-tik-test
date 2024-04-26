<?php

namespace App\Http\Requests;

use App\Schemas\EmployeeProvider1;
use App\Schemas\EmployeeProvider2;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeUpdateRequest extends FormRequest
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
        $provider = $this->route('provider');

        return match ($provider) {
            EmployeeProvider1::$providerName => EmployeeProvider1::getUpdateValidationRules($this->route('employee')),
            EmployeeProvider2::$providerName => EmployeeProvider2::getUpdateValidationRules(),
        };
    }

}
