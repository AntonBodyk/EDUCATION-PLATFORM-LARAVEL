<?php


namespace App\Http\Controllers;


use App\Http\Requests\CreateLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():object
    {
        $lessons = Lesson::all();
        return view('lessons.index', ['lessons' => $lessons]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create():object
    {
        return view('lessons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLessonRequest $request):object
    {
        if (!$request->expectsJson()) {
            $currentUser = Auth::user();
            $lessonData = array_merge($request->except('course_img'), ['teacher_id' => $currentUser->id]);

            $lessonData['title'] = mb_convert_case($lessonData['title'], MB_CASE_TITLE, 'UTF-8');
            $lessonData['description'] = mb_convert_case($lessonData['description'], MB_CASE_TITLE, 'UTF-8');

            $new_lesson = Lesson::create($lessonData);

            if ($request->hasFile('lesson_video')) {
                $lesson_video = $request->file('lesson_video');

                $path = $lesson_video->store('lesson_videos');

                $new_lesson->update(['lesson_video' => $path]);
            }

            if ($request->hasFile('lesson_exercise')) {
                $lesson_exercise = $request->file('lesson_exercise');

                $path = $lesson_exercise->store('lesson_exercises');

                $new_lesson->update(['lesson_exercise' => $path]);
            }

            return redirect()->route('lessons.index');
        } else {
            $currentUserId = $request->input('author_id');
            $courseData = array_merge($request->except('course_img'), ['author_id' => $currentUserId]);

            $courseData['title'] = mb_convert_case($courseData['title'], MB_CASE_TITLE, 'UTF-8');
            $courseData['body'] = mb_convert_case($courseData['body'], MB_CASE_TITLE, 'UTF-8');

            $new_course = Lesson::create($courseData);

            if ($request->hasFile('course_img')) {
                $course_image = $request->file('course_img');

                $path = $course_image->store('courses_images');

                $new_course->update(['course_img' => $path]);
            }
            return response()->json(['new_course' => $new_course, 'message' => 'Create successfully'], 200);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson):object
    {
        return view('lessons.edit', ['lesson'=> $lesson]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Lesson $lesson, UpdateLessonRequest $request):object
    {
        $data = $request->all();
        $lesson->update($data);
        return redirect()->route('lessons.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson, Request $request): object
    {
        $lesson->delete();

        if ($request->expectsJson()) {

            return response()->json(['user' => $lesson, 'message' => 'Deleted successfully'], 200)
                ->header('Access-Control-Allow-Methods', 'DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type,API-Key');
        }

        return redirect()->route('lessons.index');
    }
}