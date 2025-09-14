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
        Schema::create('user_lesson_stats', function (Blueprint $table) {
             $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('xp_earned')->default(0);
            $table->unsignedInteger('attempts_count')->default(0);
            $table->unsignedInteger('first_try_count')->default(0);
            $table->unsignedInteger('hints_count')->default(0);
            $table->timestamp('mastered_at')->nullable();
            $table->smallInteger('repeats_count')->default(0);
            $table->timestamps();

            $table->unique(['user_id','lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_lesson_stats');
    }
};
