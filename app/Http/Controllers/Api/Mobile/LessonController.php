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
use App\Models\Word;
use App\Models\WordSentence;
use App\Models\ExerciseInstance;

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



}
