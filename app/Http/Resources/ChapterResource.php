<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'chapter' => $this->title, // اسم الشابتر
            'lessons' => LessonResource::collection($this->lessons), // الدروس التابعة
        ];
    }
}
