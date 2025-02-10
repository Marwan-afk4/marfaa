<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
        return [
            'city_id' => ['required','exists:cities,id'],
            'area_id' => ['required','exists:areas,id'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email','unique:users,email'],
            'password' => ['required','min:8'],
            'phone' => ['nullable','unique:users,phone'],
            'gender' => ['nullable','in:male,female'],
            'age' => ['nullable','numeric'],
            'full_address' => ['nullable'],
            'test_products' => ['nullable','array'],
            'test_products.*' => ['nullable'],
            'test_products.*.name' => ['nullable'],
            // 'test_products.*.image' => ['nullable'],
            'role' => ['required','in:user,seller'],
            'identify_image' => ['nullable'],
            'floor_number' => ['nullable'],
            'apartment_number' => ['nullable'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ],400),);
    }
}
