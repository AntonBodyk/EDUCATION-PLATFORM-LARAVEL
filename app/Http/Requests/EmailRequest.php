<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailRequest extends FormRequest
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
            'report' => 'required|mimes:xlsx',
            'email' => 'required|min:3|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'report.required' => 'Файл не вибрано',
            'email.required' => 'Заповніть поле',
            'email.min' => 'Введіть мінімум 3 символи',
        ];
    }
}
