<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class CreateStatementRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'text.required' => 'The text of the statement is missing in the request. Unable to create statement.',
        ];
    }


    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(
            ['error'=>
                [
                    'message' => $validator->errors()->all()
                ]
            ], 200));
    }
}
