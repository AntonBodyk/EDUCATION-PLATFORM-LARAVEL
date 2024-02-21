<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\CompletedTest;
use Illuminate\Http\Request;

class CompletedTestController extends Controller
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
        $userId = $request->input('user_id');
        $testId = $request->input('test_id');
        $score = $request->input('score');

        $completedTest = CompletedTest::create([
            'user_id' => $userId,
            'test_id'=> $testId,
            'score'=>$score
        ]);

        return response()->json(['message' => 'Completed test created successfully']);

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
    public function destroy(string $id)
    {
        //
    }
}
