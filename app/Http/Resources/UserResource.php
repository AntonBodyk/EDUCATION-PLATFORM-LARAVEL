<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'first_name'=> $this->first_name,
            'second_name'=> $this->second_name,
            'last_name'=> $this->last_name,
            'email'=> $this->email,
            'avatar'=> Storage::url($this->avatar),
            'role_id'=> $this->role_id
        ];
    }
}
