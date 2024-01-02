<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'avatar' => 'required|image:jpg,jpeg,png',
            'name'=> 'required|min:3|max:100',
            'email'=> 'required|min:3|max:100',
            'password'=>'required|min:3|max:100',
            'role'=>'required|min:3|max:100'
        ];
    }

    public function messages()
    {
        return [
            'avatar.required' => 'Файл не вибрано',
            'name.required' => 'Заповніть поле',
            'email.required' => 'Заповніть поле',
            'password.required' => 'Заповніть поле',
            'role.required' => 'Заповніть поле',
//            'avatar.required' => 'Файл не вибрано',
            'name.min' => 'Введіть мінімум 3 символи',
            'email.min' => 'Введіть мінімум 3 символи',
            'password.min' => 'Введіть мінімум 3 символи',
            'role.min' => 'Введіть мінімум 3 символи',
        ];
    }
}
