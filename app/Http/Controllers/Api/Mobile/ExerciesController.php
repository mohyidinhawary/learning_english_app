<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use App\Models\ExercieseTemplate;
use App\Http\Resources\ExerciesResource;
use App\Http\Requests\AnswerQuestionRequest;
use App\Models\ExerciseInstance;
use App\Models\UserLessonStat;
class ExerciesController extends Controller
{
   public function showexercies($id){
 $exercise = ExercieseTemplate::with('options')->findOrFail($id);

    return new ExerciesResource($exercise);
   }

//     public function answerexercies(AnswerQuestionRequest $request, $id)
// {
//     $userId   = auth()->id(); // لازم المستخدم يكون عامل login
//     $exercise = ExercieseTemplate::with('options')->findOrFail($id);
//     $answer   = $request->validated()['answer'];

//     // ✅ تحقق من الخيار
//     $option    = $exercise->options->firstWhere('value', $answer);
//     $isCorrect = $option?->is_correct ?? false;

//     // ✅ أنشئ أو جيب instance للطالب
//     $instance = ExerciseInstance::firstOrCreate([
//         'user_id'     => $userId,
//         'lesson_id'   => $exercise->lesson_id,
//         'template_id' => $exercise->id,

//     ]);

//     // ✅ رقم المحاولة
//     $attemptNo = $instance->attempts()->count() + 1;

//     // ✅ خزّن المحاولة
//     $attempt = $instance->attempts()->create([
//         'attempt_no'        => $attemptNo,
//         'is_correct'        => $isCorrect,
//         'used_hint'         => false,
//         'selected_option_id'=> $option?->id,
//         'answer_text'       => $answer,
//         'time_ms'           => 0, // فيك تجيبه من الفرونت
//     ]);

//     // ✅ معالجة XP والإحصائيات
//     if ($isCorrect) {

//          $instance->update([
//         'status'      => 'answered_correct',
//         'answered_at' => now(),
//     ]);
//         $this->updateUserStats($userId, $exercise->lesson_id, true, false);

//         return RB::success([
//             'answer'     => $answer,
//             'is_correct' => true,
//             'attempt_no' => $attemptNo,
//             'feedback'   => "إجابة صحيحة! أحسنت 👏",
//         ]);
//     }

//     // ❌ إذا كان غلط
//     $feedback = "إجابة خاطئة ❌";

//     $instance->update([
//     'status'      => 'answered_incorrect',
//     'answered_at' => now(),
// ]);

//     // إذا غلط 3 مرات → عطِ Hint
//     if ($attemptNo >= 3) {
//         $hint = $exercise->settings['hint'] ?? 'جرّب تركز على أول حرف من الكلمة 😉';
//         $feedback .= " | Hint: {$hint}";

//         $attempt->update(['used_hint' => true]);
//         $this->updateUserStats($userId, $exercise->lesson_id, false, true);
//     } else {
//         $this->updateUserStats($userId, $exercise->lesson_id, false, false);
//     }

//     return RB::asError(422)
//     ->withHttpCode(422)
//     ->withMessage($feedback)   // هون بتحط نص الرسالة
//     ->withData([
//         'user_answer' => $answer,
//         'is_correct'  => false,
//         'attempt_no'  => $attemptNo,
//     ])
//     ->build();
// }

public function answerexercies(AnswerQuestionRequest $request, $id)
{
    $userId   = auth()->id(); // لازم المستخدم يكون عامل login
    $exercise = ExercieseTemplate::with('options')->findOrFail($id);
    $answer   = $request->validated()['answer'];

    // ✅ تحقق من الخيار
    $option    = $exercise->options->firstWhere('value', $answer);
    $isCorrect = $option?->is_correct ?? false;

    // ✅ أنشئ أو جيب instance للطالب
    $instance = ExerciseInstance::firstOrCreate([
        'user_id'     => $userId,
        'lesson_id'   => $exercise->lesson_id,
        'template_id' => $exercise->id,
    ]);

    // ✅ رقم المحاولة
    $attemptNo = $instance->attempts()->count() + 1;

    // ✅ خزّن المحاولة
    $attempt = $instance->attempts()->create([
        'attempt_no'        => $attemptNo,
        'is_correct'        => $isCorrect,
        'used_hint'         => false,
        'selected_option_id'=> $option?->id,
        'answer_text'       => $answer,
        'time_ms'           => 0, // فيك تجيبه من الفرونت
    ]);

    // ✅ عدّل حالة الـ instance
    $instance->update([
        'status'      => $isCorrect ? 'answered_correct' : 'answered_incorrect',
        'answered_at' => now(),
    ]);

    // ✅ XP والإحصائيات
    if ($isCorrect) {
         $feedback = "إجابة صحيحة! أحسنت 👏";
        // $this->updateUserStats($userId, $exercise->lesson_id, true, false);
    } else {

        $feedback = "إجابة خاطئة ❌";

        if ($attemptNo % 3 === 0) {
            $attempt->update(['used_hint' => true]);

            switch ($exercise->type) {
            case 'mcq':
                // حذف خيار غلط
                $wrongOption = $exercise->options->where('is_correct', false)->random();
                $hint = "Hint: خيار خاطئ تم حذفه → {$wrongOption->value}";
                break;

            case 'order':
                // // كشف أول كلمة صحيحة
                // $hints = $exercise->settings['hints'] ?? [];
                // $hint = isset($hints[0]['text']) ? "Hint: الكلمة الأولى هي '{$hints[0]['text']}'" : null;

              $hints = $exercise->settings['hints'] ?? [];

    if (!empty($hints)) {
        // كل 3 محاولات ننتقل لهينت جديدة
        $hintIndex = intval(($attemptNo - 1) / 3);

        // إذا ما في كفاية هينتس، كرر آخر وحدة
        if ($hintIndex >= count($hints)) {
            $hintIndex = count($hints) - 1;
        }

        $hint = $hints[$hintIndex]['text'] ?? null;
    }
    break;
            case 'translate':
            case 'fill_blank':
            case 'match':
            case 'listen':
            case 'speak':
                $hints = $exercise->settings['hints'] ?? [];
                $hint = $hints[0]['text'] ?? 'جرّب تركز على أول حرف 😉';
                break;
        }

        if ($hint) {
            $feedback .= " | {$hint}";
        }
            // $this->updateUserStats($userId, $exercise->lesson_id, false, true);
        } else {
            // $this->updateUserStats($userId, $exercise->lesson_id, false, false);
        }
    }

    // // ✅ الرسالة
    // $feedback = $isCorrect
    //     ? "إجابة صحيحة! أحسنت 👏"
    //     : "إجابة خاطئة ❌" . ($attemptNo % 3 === 0? " | Hint: " . ($exercise->settings['hint'] ?? 'جرّب تركز على أول حرف 😉') : '');

    // ✅ رجّع always success
    return RB::success([
        'user_answer' => $answer,
        'is_correct'  => $isCorrect,
        'attempt_no'  => $attemptNo,
        'feedback'    => $feedback,
    ]);
}







// private function updateUserStats($userId, $lessonId, $isCorrect, $usedHint)
// {
// //

//  $stats = UserLessonStat::firstOrCreate([
//         'user_id'   => $userId,
//         'lesson_id' => $lessonId,
//     ]);

//     $stats->attempts_count += 1;

//     // 🔹 احسب نسبة المكافأة حسب عدد مرات التكرار
//     $repeatCount = $stats->repeats_count ?? 0;
//     $multiplier = match ($repeatCount) {
//         0 => 1.0,   // أول مرة → 100%
//         1 => 0.5,   // ثاني مرة → 50%
//         2 => 0.2,   // ثالث مرة → 20%
//         default => 0.0, // أكثر من 3 → ما بياخد XP
//     };

//     if ($isCorrect) {

//         if ($stats->attempts_count == 1) {
//             $stats->xp_earned += intval(2 * $multiplier); // أول محاولة
//             $stats->first_try_count += 1;
//         } elseif ($usedHint) {
//             $stats->xp_earned += intval(0.5 * $multiplier); // بعد استخدام hint
//         } else {
//             $stats->xp_earned += intval(1 * $multiplier); // بدون hint
//         }
//     }

//     if ($usedHint) {
//         $stats->hints_count += 1;
//     }

//     $stats->save();



// }
public function wordExercises($wordId)
{
    $word = \App\Models\Word::with(['exercises.options'])
        ->findOrFail($wordId);

    return RB::success([
        'word_id'   => $word->id,
        'en_text' => $word->en_text ,
        'exercises' => $word->exercises->map(function ($exercise) {
            return [
                'exercise_id' => $exercise->id,
                'type'        => $exercise->type,
                'question'    => $exercise->question,
                // 'settings'    => $exercise->settings,
                // 'options'     => $exercise->options->map(fn($opt) => [
                //     'id'     => $opt->id,
                //     'value'  => $opt->value,
                //     'correct'=> (bool) $opt->is_correct,
                // ]),
            ];
        }),
    ]);
}


}
