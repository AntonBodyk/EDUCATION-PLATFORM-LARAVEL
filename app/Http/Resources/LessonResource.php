<?php


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'lesson_video_url' => Storage::url($this->lesson_video),
            'description' => $this->description,
            'lesson_exercise_url' => Storage::url($this->lesson_exercise),
            'teacher_id' => $this->teacher_id,
            'course_id' => $this->course_id,
        ];
    }
}
