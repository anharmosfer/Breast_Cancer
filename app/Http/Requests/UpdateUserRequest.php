<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['string','email','max:255',Rule::unique('users', 'email')->ignore(request()->user->id)],
            'phone' => 'nullable|string|max:20',
            'city' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => ['string', Rule::in(array_column(GenderEnum::cases(), 'value'))],
            'marital_status' => ['string', Rule::in(array_column(MaritalStatusEnum::cases(), 'value'))],
        ];
    }
}
