<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'city' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => ['string', Rule::in(array_column(GenderEnum::cases(), 'value'))],
            'marital_status' => ['string', Rule::in(array_column(MaritalStatusEnum::cases(), 'value'))],
        ];
    }
}
