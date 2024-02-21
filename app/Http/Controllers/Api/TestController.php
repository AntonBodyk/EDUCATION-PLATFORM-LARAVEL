<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    public function submit(Request $request, $testId)
    {
        // Получение данных из запроса
        $questionId = $request->input('question_id');
        $selectedAnswers = $request->input('selected_answers');

        // Получение объекта теста
        $test = Test::findOrFail($testId);

        // Получение объекта вопроса
        $question = Question::findOrFail($questionId);

        // Получение правильных ответов на данный вопрос из базы данных
        $correctAnswers = $question->answers()->where('is_correct', 1)->get();

        // Сравнение выбранных ответов пользователя с правильными ответами
        Log::info('Selected answers: ' . print_r($selectedAnswers, true));
        Log::info('Correct answers: ' . print_r($correctAnswers->pluck('id'), true));
        $correctCount = 0;
        foreach ($selectedAnswers as $selectedAnswer) {
            foreach ($correctAnswers as $correctAnswer) {
                if ($correctAnswer->answer_text == $selectedAnswer) {
                    $correctCount++;
                    break;
                }
            }
        }

        // Возврат ответа с количеством правильных ответов
        return response()->json(['correctAnswers' => $correctCount]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $test = Test::findOrFail($id);
        $questions = $test->questions()->with('answers')->get();

        return response()->json(['test' => $test, 'questions' => $questions]);
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
