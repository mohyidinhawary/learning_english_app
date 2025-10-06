<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('onboarding_questions', function (Blueprint $table) {
            $table->id();
             $table->enum('reason_to_learn', [
                'السفر',
                'العمل',
                'الدراسة',
                'تطوير الذات',
                'المحادثة',
            ]);

            // البلد الذي ينتمي إليه
            $table->string('country')->nullable();

            // مستوى إتقان اللغة
            $table->enum('proficiency_level', [
                'مبتدئ تماماً',
                'أستطيع التحدث قليلاً',
                'أستطيع التحدث في مواضيع يومية',
                'أستطيع التحدث بطلاقة',
            ]);

            // الخطة اليومية
            $table->enum('daily_plan', [
                'خطة خفيفة (5 دقائق يومياً)',
                'خطة متوسطة (10 دقائق يومياً)',
                'خطة مكثفة (20 دقيقة يومياً)',
                'خطة كاملة (30 دقيقة يومياً)',
            ]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboarding_questions');
    }
};
