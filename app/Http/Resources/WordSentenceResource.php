<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WordSentenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [

            'en_sentence' => $this->en_sentence,
            'ar_sentence' => $this->ar_sentence,
            'audio_url'   => $this->audio_url,
        ];
    }
}
