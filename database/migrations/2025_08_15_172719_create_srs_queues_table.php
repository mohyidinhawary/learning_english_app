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
        Schema::create('srs_queues', function (Blueprint $table) {
              $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('word_id')->nullable()->constrained('words')->nullOnDelete();
            $table->foreignId('exercise_instance_id')->nullable()->constrained('exercise_instances')->nullOnDelete();
            $table->timestamp('due_at');
            $table->string('reason')->nullable();
            $table->string('last_result')->nullable();
            $table->timestamps();

            $table->index(['user_id','due_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('srs_queues');
    }
};
