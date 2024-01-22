<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'first_name'=> 'required|min:3|max:100|regex:/^[A-ZА-Я][\p{Lu}\p{L}0-9\s]+$/u',
            'second_name'=> 'required|min:3|max:100|regex:/^[A-ZА-Я][\p{Lu}\p{L}0-9\s]+$/u',
            'last_name'=> 'required|min:3|max:100|regex:/^[A-ZА-ЯЇ][\p{Lu}\p{L}0-9\s]+$/u',
            'email'=> 'required|min:3|max:100',
            'role_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Заповніть поле',
            'avatar.image' => 'Не вірний тип файлу, додайте файл типу:jpg,jpeg,png',
            'first_name.required' => 'Заповніть поле',
            'second_name.required' => 'Заповніть поле',
            'last_name.required' => 'Заповніть поле',
            'email.required' => 'Заповніть поле',
            'role_id.required' => 'Заповніть поле',
            'first_name.min' => 'Введіть мінімум 3 символи',
            'second_name.min' => 'Введіть мінімум 3 символи',
            'last_name.min' => 'Введіть мінімум 3 символи',
            'first_name.max' => 'Максимум 100 символів',
            'second_name.max' => 'Введіть мінімум 3 символи',
            'last_name.max' => 'Введіть мінімум 3 символи',
            'email.min' => 'Введіть мінімум 3 символи',
            'email.max' => 'Максимум 100 символів',
            'name.regex'=>"Ім'я повинно починатися з великої літери",
        ];
    }
}
