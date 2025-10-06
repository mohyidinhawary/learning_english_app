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
        Schema::create('exerciese_templates', function (Blueprint $table) {
              $table->id();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
                 $table->foreignId('word_id')->constrained('words')->cascadeOnDelete();
            $table->enum('type', [
                'mcq','translate','order','listen','speak','match','fill_blank'
            ]);
            $table->text('question')->nullable();
            $table->json('settings')->nullable();
            $table->enum('status', ['draft','active','inactive'])->default('draft');
              $table->string('difficulty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exerciese_templates');
    }
};
