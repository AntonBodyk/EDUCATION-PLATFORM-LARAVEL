<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentCourse extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): object
    {
        $user_id = $request->input('user_id');
        $student_courses = $request->input('course_ids');

        // Проверить, существует ли пользователь с указанным ID
        $user = User::findOrFail($user_id);

        foreach ($student_courses as $id) {
            // Получить информацию о курсе
            $course = Course::findOrFail($id);

            $course_img_url =  Storage::url($course->course_img);

            // Создать запись в таблице course_students
            CourseStudent::create([
                'student_id' => $user_id,
                'course_id' => $id,
                'author_id' => $course->author_id,
                'average_rating' => $course->average_rating,
                'body' => $course->body,
                'category_id' => $course->category_id,
                'course_img_url' => $course_img_url,
                'course_price' => $course->course_price,
                'title' => $course->title,
            ]);
        }

        // Проверить, что массив ID курсов не пуст
        if (empty($student_courses)) {
            return response()->json(['error' => 'No courses selected'], 400);
        }

        // Присоединить выбранные курсы к пользователю и автоматически заполнить pivot-таблицу
        $user->enrolledCourses()->attach($student_courses);

        // Успешный ответ клиенту
        return response()->json(['message' => 'Courses purchased and attached successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return CourseStudent::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseStudent $courseStudent, Request $request): object
    {
        $courseStudent->delete();


        if ($request->expectsJson()) {

            return response()->json(['course' => $courseStudent, 'message' => 'Deleted successfully'], 200)
                ->header('Access-Control-Allow-Methods', 'DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type,API-Key');
        }

        return redirect()->route('courses.index');
    }
}
