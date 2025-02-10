<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
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
            'user_id'=>['nullable','exists:users,id'],
            'category_id'=>['required','exists:categories,id'],
            'subCategory_id'=>['required','exists:sub_categories,id'],
            'name'=>['required'],
            'description'=>['required'],
            'price'=>['required'],
            'location'=>['required'],
            'quantity'=>['required','min:1'],
            'size'=>['nullable'],
            'color'=>['nullable'],
            'images'=>['nullable','array'],
            'images.*'=>['nullable'],
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
