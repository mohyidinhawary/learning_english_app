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
        Schema::create('chapters', function (Blueprint $table) {
           $table->id();
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->smallInteger('position'); // per level
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['level_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
