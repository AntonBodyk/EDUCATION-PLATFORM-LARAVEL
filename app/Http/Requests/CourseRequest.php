<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'title'=> 'required|min:3|max:100|regex:/^[A-ZА-Я][\p{Lu}\p{L}0-9\s, -]+$/u',
            'course_img' => 'required|image:jpg,jpeg,png',
            'body'=> 'required|min:3|max:500|regex:/^[A-ZА-Я][\p{Lu}\p{L}0-9\s, -]+$/u',
            'category_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'=> 'Заповніть поле',
            'course_img.required' => 'Заповніть поле',
            'body.required'=> 'Заповніть поле',
            'category_id.required' => 'Заповніть поле',
            'title.min' => 'Введіть мінімум 3 символи',
            'body.min' => 'Введіть мінімум 3 символи',
            'title.regex'=> 'Назва повинна починатися з великої літери',
            'body.regex'=> 'Опис повинен починатися з великої літери'
        ];
    }
}
