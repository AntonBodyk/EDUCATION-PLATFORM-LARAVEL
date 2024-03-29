<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\TestResource;
use App\Models\Category;
use App\Models\Course;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): object
    {

        $sortColumn = $request->get('sortColumn', 'id');
        $sortDirection = $request->get('sortDirection', 'asc');

        $validColumns = ['id', 'title', 'body', 'category'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'title';
        }

        $coursesQuery = Course::orderBy($sortColumn, $sortDirection);

        if ($request->filled('categoryFilter')) {
            $coursesQuery->whereHas('category', function ($query) use ($request) {
                $query->where('category_name', $request->input('categoryFilter'));
            });
        }


        $courses = $coursesQuery->with('category')->paginate(50);


        if ($request->input('page') > $courses->lastPage()) {
            abort(404);
        }

        if ($request->expectsJson()){
            return CourseResource::collection(Course::all());
        }

        return view('courses.index', compact('courses', 'sortColumn', 'sortDirection'));
    }

    public function search(Request $request): object
    {
        $query = $request->get('searchQuery', '');
        $userId = $request->get('userId', null);
        $categoryId = $request->get('categoryId', null);

        $coursesQuery = Course::where('title', 'like', "%$query%");

        if ($userId !== null) {
            $coursesQuery->whereHas('students', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            });
        }

        if ($categoryId !== null) {
            $coursesQuery->whereHas('category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            });
        }

        $courses = $coursesQuery->get();

        return CourseResource::collection($courses);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(): object
    {
        $categories = Category::all();
        return view('courses.create', ['categories'=> $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCourseRequest $request): object
    {

        if(!$request->expectsJson()){
            $currentUser = Auth::user();
            $courseData = array_merge($request->except('course_img'), ['author_id' => $currentUser->id]);

            $courseData['title'] = mb_convert_case($courseData['title'], MB_CASE_TITLE, 'UTF-8');
            $courseData['body'] = mb_convert_case($courseData['body'], MB_CASE_TITLE, 'UTF-8');

            $new_course = Course::create($courseData);

            if ($request->hasFile('course_img')) {
                $course_image = $request->file('course_img');

                $path = $course_image->store('courses_images');

                $new_course->update(['course_img' => $path]);
            }

            return redirect()->route('courses.index');
        }else{
            $currentUserId = $request->input('author_id');
            $courseData = array_merge($request->except('course_img'), ['author_id' => $currentUserId]);

            $courseData['title'] = mb_convert_case($courseData['title'], MB_CASE_TITLE, 'UTF-8');
            $courseData['body'] = mb_convert_case($courseData['body'], MB_CASE_TITLE, 'UTF-8');

            $new_course = Course::create($courseData);

            if ($request->hasFile('course_img')) {
                $course_image = $request->file('course_img');

                $path = $course_image->store('courses_images');

                $new_course->update(['course_img' => $path]);
            }
            return response()->json(['new_course' => $new_course, 'message' => 'Create successfully'], 200);
        }

    }

    public function lessons(string $id): object
    {
        $course = Course::findOrFail($id);
        $lessons = $course->lessons;
        return LessonResource::collection($lessons);
    }

    public function tests(string $id): object
    {
        $course = Course::findOrFail($id);
        $tests = $course->tests;
        return TestResource::collection($tests);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id):object
    {
        return new CourseResource(Course::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): object
    {
        $categories = Category::all();
        return view('courses.edit', ['course'=> $course], ['categories'=> $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course): object
    {
        $data = $request->all();
        $course->update($data);
        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Request $request): object
    {
        $course->delete();

        if ($request->expectsJson()) {

            return response()->json(['course' => $course, 'message' => 'Deleted successfully'], 200)
                ->header('Access-Control-Allow-Methods', 'DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type,API-Key');
        }

        return redirect()->route('courses.index');
    }
}
