<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'en_text'   => $this->en_text,
            'ar_text'   => $this->ar_text,
            'image_url' => $this->image_url,
            'audio_url' => $this->audio_url,


        ];
    }
}
