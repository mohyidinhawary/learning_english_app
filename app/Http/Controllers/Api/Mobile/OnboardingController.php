<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder as RB;
use App\Models\OnboardingQuestion;
class OnboardingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'reason_to_learn'    => 'required|in:السفر,العمل,الدراسة,تطوير الذات,المحادثة',
            'country'            => 'nullable|string|max:255',
            'proficiency_level'  => 'required|in:مبتدئ تماماً,أستطيع التحدث قليلاً,أستطيع التحدث في مواضيع يومية,أستطيع التحدث بطلاقة',
            'daily_plan'         => 'required|in:خطة خفيفة (5 دقائق يومياً),خطة متوسطة (10 دقائق يومياً),خطة مكثفة (20 دقيقة يومياً),خطة كاملة (30 دقيقة يومياً)',
        ]);



        $onboarding = OnboardingQuestion::updateOrCreate(

            $data
        );

        return RB::success($onboarding);
    }

}
