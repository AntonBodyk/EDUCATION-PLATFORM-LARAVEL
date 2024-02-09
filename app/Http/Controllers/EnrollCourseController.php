<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EnrollCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): object
    {
        // Получаем пользователя
        $userId = $request->input('user_id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Получаем курсы, к которым пользователь был записан

        $enrolledCourses = $user->enrolledCourses()->get();

        $coursesResource = CourseResource::collection($enrolledCourses);

        // Возвращаем данные
        return response()->json(['enrolledCourses' => $coursesResource], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): object
    {
        $userId = $request->input('user_id');
        $courseIds = $request->input('course_ids');

        // Проверяем, существует ли пользователь с указанным ID
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Проверяем, существуют ли курсы с указанными ID
        $courses = Course::whereIn('id', $courseIds)->get();
        if ($courses->count() !== count($courseIds)) {
            return response()->json(['error' => 'One or more courses not found'], 404);
        }

        // Присоединяем выбранные курсы к пользователю
        $user->enrolledCourses()->syncWithoutDetaching($courseIds);

        return response()->json(['message' => 'Courses enrolled successfully'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy()
    {
       //
    }
}
