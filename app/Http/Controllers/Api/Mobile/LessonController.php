<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use App\Http\Resources\LessonResource;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use App\Http\Resources\WordResource;
use App\Http\Resources\WordSentenceResource;
use App\Models\ExercieseTemplate;
use App\Models\Word;
use App\Models\WordSentence;
use App\Models\ExerciseInstance;
use App\Models\UserLessonStat;
use App\Services\EventLogger;
class LessonController extends Controller
{
   public function showchapterlessons($id){
   $chapter = Chapter::with('lessons')->findOrFail($id);

    return RB::success(new ChapterResource($chapter));
   }


   public function showlessonwords($id){
   $lesson = Lesson::with('words')->findOrFail($id);

    return RB::success([

        'words'  => WordResource::collection($lesson->words),
    ]);
   }


   public function showlessonsentence($id){
    $lesson = Lesson::with('words.sentences')->findOrFail($id);

    // نجمع كل الجمل المرتبطة بالكلمات
    $sentences = $lesson->words->flatMap->sentences;

    return RB::success([

        'sentences' => WordSentenceResource::collection($sentences),
    ]);
   }


public function showword($id){
   $word = Word::findOrFail($id);

    return RB::success([

        'words'  =>new WordResource($word),
    ]);
   }


   public function showsentence($id){
    $sentence = WordSentence::findOrFail($id);

    // نجمع كل الجمل المرتبطة بالكلمات


    return RB::success([

        'sentences' =>new WordSentenceResource($sentence),
    ]);
   }





   public function reviewMistakes($lessonId)
{
    $userId = auth()->id();

    // كل التمارين الغلط لهالطالب بهالدرس
    $incorrectInstances = ExerciseInstance::with('template.options')
        ->where('user_id', $userId)
        ->where('lesson_id', $lessonId)
        ->where('status', 'answered_incorrect')
        ->get();

    if ($incorrectInstances->isEmpty()) {
        return RB::success([
            'message' => 'ما عندك أخطاء، كل الإجابات صحيحة 👏',
            'mistakes' => [],
        ]);
    }

    return RB::success([
    'message' => 'رجع جاوب على الأخطاء لتكمل الدرس',
    "mistakes_count"=>$incorrectInstances->count(),
    'mistakes' => $incorrectInstances->map(function ($instance) {
        return [
            'exercise_id' => $instance->id,
            'question'    => $instance->template->question,
            // 'settings'    => $instance->template->settings,
            // 'options'     => $instance->template->options->map(function ($opt) {
            //     return [
            //         'id'    => $opt->id,
            //         'value' => $opt->value,
            //     ];
            // }),
            // 🔹 هون عم نجيب كل المحاولات مع تفاصيلها
            'attempts'    => $instance->attempts->map(function ($attempt) {
                return [
                    'attempt_no'   => $attempt->attempt_no,
                    'user_answer'  => $attempt->answer_text,
                    // 'is_correct'   => (bool) $attempt->is_correct,
                    // 'used_hint'    => (bool) $attempt->used_hint,
                    // 'created_at'   => $attempt->created_at->toDateTimeString(),
                ];
            }),
        ];
    }),
]);
}









public function finalizeLesson($lessonId)
{
    $userId = auth()->id();

    // جيب كل الـ instances تبع الدرس
    $instances = ExerciseInstance::where('user_id', $userId)
        ->where('lesson_id', $lessonId)
        ->with(['attempts' => function ($q) {
            $q->orderBy('attempt_no', 'asc');
        }])
        ->get();

    // تحقق إذا كل التمارين جاوبة صح بالنهاية
    $allCorrect = $instances->every(fn($i) => $i->status === 'answered_correct');

    if (!$allCorrect) {
     return RB::asError(400)
    ->withHttpCode(400)
    ->withMessage("لسا ما خلصت الدرس، في تمارين ما انحلت صح")
    ->build();
    }

    $totalXp = 0;

    foreach ($instances as $instance) {
        // جيب أول محاولة صحيحة
        $firstCorrect = $instance->attempts->firstWhere('is_correct', true);

        if (!$firstCorrect) {
            continue;
        }

        $attemptNo = $firstCorrect->attempt_no;
        $usedHint  = $firstCorrect->used_hint;
$firsttrycount=$firstCorrect->first_try_count;

$lesson = Lesson::findOrFail($lessonId);
$baseXp = $lesson->xp; // القيمة الأساسية المخزنة بالجدول
        if ($attemptNo == 1) {
$firsttrycount+=1;
            $totalXp = $baseXp; // أول محاولة
        } elseif ($usedHint) {
            $totalXp =$baseXp-6; // صح بعد استخدام hint
        } else {
            $totalXp =$baseXp-3; // صح بعد تكرار بدون hint
        }
    }

    // خزّن النتيجة بجدول user_lesson_stats
    $stats = UserLessonStat::firstOrCreate([
        'user_id'   => $userId,
        'lesson_id' => $lessonId,
    ]);

    $stats->xp_earned = $totalXp;
    $stats->mastered_at = now();
    $stats->first_try_count=$firsttrycount?? 0;
    $stats->save();
 EventLogger::record('xp_gained', [
        'user_id'   => $userId,
        'lesson_id' => $lessonId,
        'xp'        => $totalXp,
        'base_xp'   => $baseXp,
        'first_try' => $firsttrycount,
        'time'      => now()->toIso8601String(),
    ]);




    return RB::success([
        'lesson_id' => $lessonId,
        'xp_total'  => $totalXp,
        'message'   => "🎉 مبروك! خلصت الدرس وكسبت {$totalXp} XP",
    ]);
}

public function showlessonexerciesies($id){
$lesson_exercieses=ExercieseTemplate::where('lesson_id',$id)->select('id','type','question','difficulty')->get( );


return RB::success([
        'lesson_exercieses' => $lesson_exercieses,

    ]);
}


}
