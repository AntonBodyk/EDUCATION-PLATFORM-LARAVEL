<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=> $this->id,
            'title'=>$this->title,
            'course_img_url'=> Storage::url($this->course_img),
            'body'=> $this->body,
            'author_id'=> $this->author_id,
            'author'=>$this->author->only(['second_name', 'first_name', 'last_name']),
            'course_price'=> $this->course_price,
            'category_id'=>$this->category_id
        ];
    }
}
