<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): object
    {
        // Получите параметры сортировки из запроса
        $sortColumn = $request->get('sortColumn', 'title');
        $sortDirection = $request->get('sortDirection', 'asc');

        $validColumns = ['id', 'title', 'body', 'category'];
        if (!in_array($sortColumn, $validColumns)) {
            $sortColumn = 'title';
        }

        // Получите запрос на курсы, отсортированных и разбитых по страницам
        $coursesQuery = Course::orderBy($sortColumn, $sortDirection);

        // Примените фильтр по категориям, если он установлен
        if ($request->filled('categoryFilter')) {
            $coursesQuery->whereHas('category', function ($query) use ($request) {
                $query->where('category_name', $request->input('categoryFilter'));
            });
        }

        // Получите курсы, отсортированных и разбитых по страницам
        $courses = $coursesQuery->paginate(50);

        // Проверьте, допустимы ли значения номера страницы
        if ($request->input('page') > $courses->lastPage()) {
            abort(404);
        }

        return view('courses.index', compact('courses', 'sortColumn', 'sortDirection'));
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
    public function store(CourseRequest $request): object
    {
        $new_user = Course::create($request->except('course_img'));

        if ($request->hasFile('course_img')) {
            $avatar = $request->file('course_img');

            $path = $avatar->store('courses_images');

            $new_user->update(['course_img' => $path]);
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
    public function update(CourseRequest $request, Course $course): object
    {
        $data = $request->except('course_img');
        if ($request->hasFile('course_img')) {
            $course_img = $request->file('course_img');
            $path = $course_img->store('courses_images');
            $data['course_img'] = $path;
        }



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
