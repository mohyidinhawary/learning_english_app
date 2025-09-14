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
        Schema::create('attempts', function (Blueprint $table) {
           $table->id();
            $table->foreignId('exercise_instance_id')->constrained('exercise_instances')->cascadeOnDelete();
            $table->smallInteger('attempt_no');
            $table->boolean('is_correct')->default(false);
            $table->boolean('used_hint')->default(false);
            $table->foreignId('selected_option_id')->nullable()->constrained('exercise_options')->nullOnDelete();
            $table->text('answer_text')->nullable();
            $table->unsignedInteger('time_ms')->default(0);
            $table->timestamps();

            $table->index(['exercise_instance_id','attempt_no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempts');
    }
};
