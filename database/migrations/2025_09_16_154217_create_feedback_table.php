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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('experience'); // 1-5 (ضعيفة → ممتازة)
    $table->string('easy_to_understand'); // 0=لا، 1=أحياناً، 2=نعم
    $table->string('continue_next_level'); // 0=لا، 1=ربما لاحقاً، 2=نعم
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
