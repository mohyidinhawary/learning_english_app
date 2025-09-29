<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use App\Models\Word;
use App\Models\UserWordStat;
use App\Models\UserWordSentenceStat;
class WordController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->id();

        $validated = $request->validate([
            'words'   => 'required|array',
            'words.*.id'     => 'required|exists:words,id',
            'words.*.status' => 'required|in:unknown,known,mastered',
        ]);

        foreach ($validated['words'] as $word) {
            UserWordStat::updateOrCreate(
                [
                    'user_id' => $userId,
                    'word_id' => $word['id'],
                ],
                [
                    'status' => $word['status'],
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الكلمات بنجاح ✅',
        ]);
    }



    public function review(Request $request)
    {
        $userId = auth()->id();
        $filter = $request->get('filter', 'all'); // default all

        switch ($filter) {
            case 'learned': // كلمات تعلمتها
                $words = UserWordStat::with('word')
                    ->where('user_id', $userId)
                    ->where('status', 'known')
                    ->get();
                return response()->json(['type' => 'words', 'data' => $words]);

            case 'unknown': // كلمات تعرفها
                $words = UserWordStat::with('word')
                    ->where('user_id', $userId)
                    ->where('status', 'unknown')
                    ->get();
                return response()->json(['type' => 'words', 'data' => $words]);

            case 'sentences': // جمل تعلمتها
                $sentences = UserWordSentenceStat::with('sentence')
                    ->where('user_id', $userId)
                    ->where('status', 'learned')
                    ->get();
                return response()->json(['type' => 'sentences', 'data' => $sentences]);

            case 'all': // الكل
            default:
                $words = UserWordStat::with('word')
                    ->where('user_id', $userId)
                    ->get();
                $sentences = UserWordSentenceStat::with('sentence')
                    ->where('user_id', $userId)
                    ->get();

                return response()->json([
                    'type' => 'all',
                    'words' => $words,
                    'sentences' => $sentences,
                ]);
        }
    }
}
