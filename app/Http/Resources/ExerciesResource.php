<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'id'       => $this->id,
            // 'lesson_id'=> $this->lesson_id,
            'question' => $this->question,
            // 'type'     => $this->type,
            'settings'   => $this->settings,
            'options'  => ExerciesOpResource::collection($this->whenLoaded('options')),
        ];
    }
}
