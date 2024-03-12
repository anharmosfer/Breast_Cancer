<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'email' => ['string','email','max:255',Rule::unique('users', 'email')->ignore(request()->user()->id)],
            'password' => 'string|min:8',
            'phone' => 'nullable|string|max:20',
            'city' => 'string|max:255',
            'birthdate' => 'date',
            'gender' => ['string', Rule::in(array_column(GenderEnum::cases(), 'value'))],
            'marital_status' => ['string', Rule::in(array_column(MaritalStatusEnum::cases(), 'value'))],
        ];
    }
}
