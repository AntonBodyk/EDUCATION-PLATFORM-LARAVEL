<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
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


        $courses = $coursesQuery->paginate(50);

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
        $query = $request->get('query', '');

        $coursesQuery = Course::where('title', 'like', "%$query%");

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

        $currentUser = Auth::user();
        $courseData = array_merge($request->except('course_img'), ['user_id' => $currentUser->id]);
        $new_course = Course::create($courseData);

        if ($request->hasFile('course_img')) {
            $course_image = $request->file('course_img');

            $path = $course_image->store('courses_images');

            $new_course->update(['course_img' => $path]);
        }


        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(Course $course): object
    {
        $course->delete();
        return redirect()->route('courses.index');
    }
}
