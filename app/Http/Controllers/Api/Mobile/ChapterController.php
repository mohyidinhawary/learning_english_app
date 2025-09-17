<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\UserLessonStat;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
class ChapterController extends Controller
{
    public function finalizeChapter($chapterId)
{
    $userId = auth()->id();

    // 1. جيب الشابتر مع كل دروسه
    $chapter = Chapter::with('lessons')->findOrFail($chapterId);
    $lessonIds = $chapter->lessons->pluck('id');

    // 2. جيب احصائيات المستخدم لهالدروس
    $userStats = UserLessonStat::where('user_id', $userId)
        ->whereIn('lesson_id', $lessonIds)
        ->get();

    // 3. تحقق إذا كل الدروس عندها Mastered
    $allLessonsDone = $userStats->count() === $lessonIds->count() &&
                      $userStats->every(fn($s) => !is_null($s->mastered_at));

    if (!$allLessonsDone) {
        return RB::asError(400)
            ->withHttpCode(400)
            ->withMessage("لسا ما خلصت كل دروس الشابتر")
            ->build();
    }

    // 4. حساب XP الكلي
    $totalXp = $userStats->sum('xp_earned');

    // 5. خزّن بالشابتر
    $chapterStats = \App\Models\UserChapterStat::firstOrCreate([
        'user_id'    => $userId,
        'chapter_id' => $chapterId,
    ]);

    $chapterStats->xp_earned = $totalXp;
    $chapterStats->lessons_completed = $lessonIds->count();
    $chapterStats->mastered_at = now();
      $chapterStats->badges_count += 1;
    $chapterStats->save();

    return RB::success([
        'chapter_id' => $chapterId,
        'xp_total'   => $totalXp,
        'badge'      => '🏅 حصلت على وسام إكمال الشابتر!',
    ]);
}
}
