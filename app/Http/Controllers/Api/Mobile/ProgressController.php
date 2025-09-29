<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserLessonStat;
use App\Models\UserChapterStat;
use App\Models\UserWordStat;
use App\Models\UserStreak;
class ProgressController extends Controller
{
   public function index(Request $request)
    {
        $userId = auth()->id();

        // عدد الدروس المنجزة
        $completedLessons = UserLessonStat::where('user_id', $userId)
            ->whereNotNull('mastered_at') // الدرس خلص
            ->count();

        // عدد الفصول المنجزة
        $completedChapters = UserChapterStat::where('user_id', $userId)
            ->whereNotNull('mastered_at')
            ->count();

        // مجموع الـ XP من الدروس والفصول
        $xpFromLessons  = UserLessonStat::where('user_id', $userId)->sum('xp_earned');
        $xpFromChapters = UserChapterStat::where('user_id', $userId)->sum('xp_earned');
        $totalXp = $xpFromLessons + $xpFromChapters;

        // الكلمات المكتسبة (ممكن تعتمد على جدول UserWordStat عندك)
        $learnedWords = UserWordStat::where('user_id', $userId)
            ->whereIn('status', ['known', 'mastered'])
            ->count();

        // streaks
        $streak = UserStreak::where('user_id', $userId)->first();

        return response()->json([
            'lessons_completed'  => $completedLessons,
            'chapters_completed' => $completedChapters,
            'words_learned'      => $learnedWords,
            'rewards' => [
                'xp'     => $totalXp,
                'badges' => UserChapterStat::where('user_id', $userId)->sum('badges_count'),
            ],
            'streak' => [
                'current'     => $streak->current_streak ?? 0,
                'longest'     => $streak->longest_streak ?? 0,
                'last_active' => $streak->last_active_date ?? null,
            ],
        ]);
    }
}
