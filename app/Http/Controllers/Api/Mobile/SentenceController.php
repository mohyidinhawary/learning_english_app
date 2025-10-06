<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserWordSentenceStat;
class SentenceController extends Controller
{
   public function store(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'sentences'   => 'required|array',
            'sentences.*.id'     => 'required|exists:word_sentences,id',
            'sentences.*.status' => 'required|in:unknown,known,mastered',
        ]);

        foreach ($validated['sentences'] as $sentence) {
            UserWordSentenceStat::updateOrCreate(
                [
                    'user_id' => $userId,
                    'word_sentece_id' => $sentence['id'],
                ],
                [
                    'status' => $sentence['status'],
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الجمل بنجاح ✅',
        ]);
    }
}
