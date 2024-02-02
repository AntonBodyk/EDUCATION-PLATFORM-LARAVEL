<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLessonRequest extends FormRequest
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
            'title' => "required|min:3|max:100|regex:/^[\p{Lu}\p{L}0-9\s, '.-]+$/u",
            'lesson_video' => 'required|mimes:mp4,mov,avi,wmv',
            'description' => "required|min:3|max:500|regex:/^[\p{Lu}\p{L}0-9\s, '.-]+$/u",
            'lesson_exercise' => 'required|mimes:pdf'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заповніть поле',
            'lesson_video.required' => 'Заповніть поле',
            'description.required' => 'Заповніть поле',
            'title.min' => 'Введіть мінімум 3 символи',
            'description.min' => 'Введіть мінімум 3 символи',
            'title.max' => 'Максимум 100 символів',
            'description.max' => 'Максимум 500 символів',
            'lesson_video' => 'Не вірний тип файлу, додайте файл типу:mp4,mov,avi,wmv',
            'title.regex' => 'Назва повинна починатися з великої літери',
            'description.regex' => 'Опис повинен починатися з великої літери',
            'lesson_exercise.required' => 'Заповніть поле'
        ];
    }
}
