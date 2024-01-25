<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'first_name'=> 'required|min:3|max:100|regex:/^[a-zA-Zа-яА-ЯёЁіІїЇґҐєЄ]+\s*$/u',
            'second_name'=> 'required|min:3|max:100|regex:/^[a-zA-Zа-яА-ЯёЁіІїЇґҐєЄ]+\s*$/u',
            'last_name'=> 'required|min:3|max:100|regex:/^[a-zA-Zа-яА-ЯёЁіІїЇґҐєЄ]+\s*$/u',
            'email'=> 'required|email|unique:users|min:3|max:100',
            'password'=>'required|min:3|max:100|regex:/^[A-ZА-Я][\p{Lu}\p{L}0-9\s]+$/u',
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
            'email.email'=> 'Не вірний тип email',
            'email.unique'=> 'Користувач з таким email вже зареєстрований',
            'password.required' => 'Заповніть поле',
            'role_id.required' => 'Заповніть поле',
            'first_name.min' => 'Введіть мінімум 3 символи',
            'second_name.min' => 'Введіть мінімум 3 символи',
            'last_name.min' => 'Введіть мінімум 3 символи',
            'first_name.max' => 'Максимум 100 символів',
            'second_name.max' => 'Введіть мінімум 3 символи',
            'last_name.max' => 'Введіть мінімум 3 символи',
            'email.min' => 'Введіть мінімум 3 символи',
            'email.max' => 'Максимум 100 символів',
            'password.min' => 'Введіть мінімум 3 символи',
            'password.max' => 'Максимум 100 символів',
            'first_name.regex'=>"Ім'я не повинно містити цифри",
            'second_name.regex'=>"Прізвище не повинно містити цифри",
            'last_name.regex'=>"Ім'я по батькові не повинно містити цифри",
            'password.regex'=>"Пароль повинен починатися з великої літери"
        ];
    }
}
