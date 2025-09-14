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
        Schema::create('word_sentences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->constrained('words')->cascadeOnDelete();
            $table->text('en_sentence');
            $table->text('ar_sentence');
            $table->string('audio_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_sentences');
    }
};
