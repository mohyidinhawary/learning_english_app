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



}
