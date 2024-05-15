<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeRequest extends FormRequest
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
        $rules = [
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string',
            'departmen' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'status' => 'required|string',
        ];

        if ($this->method() == "POST") {
            $rules['foto'] = 'required|image';
            $rules['nomor'] = 'required|numeric|unique:employees,nomor';
        }

        if ($this->method() == "PUT") {
            $rules['foto'] = 'nullable|image';
            $rules['nomor'] = 'nullable|numeric';
        }

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => $validator->errors()->first(),
            'data'      => $validator->errors(),
        ], 422));
    }

    public function messages()
    {
        return [
            'string' => ':attribute harus string',
            'required' => ':attribute harus diisi',
            'numeric' => ':attribute harus nomor',
        ];
    }
}
