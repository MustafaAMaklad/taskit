<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TaskResource extends JsonResource
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
            'title' => Str::title($this->title),
            'description' => $this->whenNotNull($this->description),
            'status' => $this->status,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
            'subtasks' => TaskResource::collection($this->whenLoaded('subTasks')),
        ];
    }
}
