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
        Schema::create('exercise_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->foreignId('template_id')->constrained('exerciese_templates')->cascadeOnDelete();
            $table->foreignId('word_id')->nullable()->constrained('words')->nullOnDelete();
            $table->enum('status', ['not_shown','shown','answered_correct','answered_incorrect'])->default('not_shown');
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamp('shown_at')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();

            $table->index(['user_id','lesson_id','status','display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_instances');
    }
};
