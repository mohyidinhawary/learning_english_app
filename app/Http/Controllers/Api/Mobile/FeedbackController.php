<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Http\Requests\FeedbackRequest;
class FeedbackController extends Controller
{
   public function sendfeedback(FeedbackRequest $request)
{
    $data = $request->validated();

    Feedback::create([
        'user_id' => auth()->id(),
        'experience' => $data['experience'],
        'easy_to_understand' => $data['easy_to_understand'],
        'continue_next_level' => $data['continue_next_level'],
    ]);

    return response()->json(['message' => 'شكراً على تقييمك 🙏']);
}
}
