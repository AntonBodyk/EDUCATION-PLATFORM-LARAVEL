<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            'title' => "required|min:3|max:100|regex:/^[A-ZА-ЯЇІЄЁҐ][\p{Lu}\p{L}0-9\s, '.-]+$/u",
            'description' => "required|min:3|max:500|regex:/^[A-ZА-ЯЇІЄЁҐ][\p{Lu}\p{L}0-9\s, '.-]+$/u",
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заповніть поле',
            'description.required' => 'Заповніть поле',
            'title.min' => 'Введіть мінімум 3 символи',
            'description.min' => 'Введіть мінімум 3 символи',
            'title.max' => 'Максимум 100 символів',
            'description.max' => 'Максимум 500 символів',
            'title.regex' => 'Назва повинна починатися з великої літери',
            'description.regex' => 'Опис повинен починатися з великої літери'
        ];
    }
}
