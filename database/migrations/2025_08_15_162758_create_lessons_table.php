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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->smallInteger('position'); // per chapter
            $table->boolean('is_free')->default(false);
            $table->string('difficulty')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->unique(['chapter_id','position']);
            $table->index(['chapter_id','is_free']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
