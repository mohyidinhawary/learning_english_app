<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use App\Models\ExercieseTemplate;
use App\Http\Resources\ExerciesResource;
use App\Http\Requests\AnswerQuestionRequest;
class ExerciesController extends Controller
{
   public function showexercies($id){
 $exercise = ExercieseTemplate::with('options')->findOrFail($id);

    return new ExerciesResource($exercise);
   }

    public function answerexercies(AnswerQuestionRequest $request,$id){
 $exercise = ExercieseTemplate::with('options')->findOrFail($id);
$answer = $request->validated()['answer'];
 $isCorrect = false;
// ✅ إذا كان التمرين من النوع MCQ أو listen أو match → تحقق من الخيارات
    if (in_array($exercise->type, ['mcq','listen','match',"order"])) {
        $option = $exercise->options->firstWhere('value', $answer);
        $isCorrect = $option?->is_correct ?? false;
    }

    // // ✅ إذا كان من النوع fill_blank → الجواب موجود بالـ settings
    // if ($exercise->type === 'fill_blank') {
    //     $correctAnswer = $exercise->settings['correct_answer'] ?? null;
    //     $isCorrect = trim(strtolower($answer)) === trim(strtolower($correctAnswer));
    // }

    // // ✅ إذا كان من النوع order → نقارن الترتيب
    // if ($exercise->type === 'order') {
    //     $correctItems = $exercise->settings['items'] ?? [];
    //     $isCorrect = $answer === implode(' ', array_column($correctItems, 'word'));
    // }





    return RB::success([ 'answer'      => $answer,
'is_correct'  => $isCorrect,

],200);
   }
}
