<?php

namespace App\Http\Requests;

use App\Enums\AgeRangeEnum;
use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'gender' => ['array', 'required', Rule::in(array_values(GenderEnum::toArray()))],
            'gender.*' => 'integer', // Assuming each gender value is an integer
            'marital_status' => ['array', 'required', Rule::in(array_values(MaritalStatusEnum::toArray()))],
            'marital_status.*' => 'integer', // Assuming each marital status value is an integer
            'birthdate' => ['array', 'required', Rule::in(array_values(AgeRangeEnum::toArray()))],
            'birthdate.*' => 'integer', // Assuming each birthdate value is an integer
            'rate' => 'nullable|numeric',
        ];
}
}
