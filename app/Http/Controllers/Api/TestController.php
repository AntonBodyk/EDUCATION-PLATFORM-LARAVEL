<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
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
    public function store(Request $request)
    {
        $test = Test::create([
            'title' => $request->input('title'),
            'course_id'=> $request->input('course_id'),
            'teacher_id'=> $request->input('teacher_id')
        ]);

        // Для каждого вопроса в тесте
        foreach ($request->input('questions') as $questionData) {
            // Создаем новый вопрос и связываем его с тестом
            $question = $test->questions()->create([
                'question_title' => $questionData['questionText'],
                'test_id'=> $request->input('test_id')
            ]);

            // Для каждого ответа на вопрос
            foreach ($questionData['answers'] as $answerData) {
                // Создаем новый ответ и связываем его с вопросом
                $question->answers()->create([
                    'answer_text' => $answerData['answerText'],
                    'is_correct' => $answerData['isCorrect']
                ]);
            }
        }

        return response()->json(['message' => 'Тест успешно создан']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Test::findOrFail($id);
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
    public function destroy(string $id)
    {
        //
    }
}
