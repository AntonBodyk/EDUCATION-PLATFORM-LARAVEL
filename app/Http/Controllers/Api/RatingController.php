<?php
namespace App\Http\Controllers\Api;

use App\Models\Course;
use App\Models\CourseRating;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rateCourse($courseId, Request $request): JsonResponse
    {
        $userId = $request->input('user_id');

        $existingRating = CourseRating::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->first();

        if ($existingRating) {
            return response()->json(['message' => 'Вы уже оценили этот курс'], 422);
        }


        $rating = new CourseRating([
            'user_id' => $userId,
            'course_id' => $courseId,
            'course_rating' => request('course_rating')
        ]);

        $rating->save();


        $averageRating = CourseRating::where('course_id', $courseId)->avg('course_rating');
        $course = Course::find($courseId);
        $course->average_rating = $averageRating;
        $course->save();

        return response()->json(['average_rating' => $averageRating], 200);
    }
}
