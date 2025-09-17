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
        Schema::create('user_chapter_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('xp_earned')->default(0); // مجموع XP لكل دروس الشابتر
            $table->unsignedInteger('lessons_completed')->default(0);
             $table->unsignedInteger('badges_count')->default(0); // عدد الأوسمة 🏅
            $table->timestamp('mastered_at')->nullable(); // وقت إنهاء الشابتر
            $table->timestamps();

            $table->unique(['user_id','chapter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_chapter_stats');
    }
};
