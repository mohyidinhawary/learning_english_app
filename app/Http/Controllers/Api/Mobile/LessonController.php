<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use App\Http\Resources\LessonResource;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;

class LessonController extends Controller
{
   public function showchapterlessons($id){
   $chapter = Chapter::with('lessons')->findOrFail($id);

    return RB::success(new ChapterResource($chapter));
   }
}
