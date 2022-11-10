<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddressStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'addresses' => 'array',
            'addresses.*' => 'required',
            'default' => 'nullable'
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'addresses.array' =>'addresses should be an array array!',
    //         'addresses.*.required' =>'addresses is required!'
    //     ];
    // }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            "code" => "01",
            "message" => $errors
        ]);

        throw new HttpResponseException($response);
    }
}
