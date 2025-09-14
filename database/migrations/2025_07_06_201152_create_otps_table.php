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
        Schema::create('otps', function (Blueprint $table) {
             $table->id();

            $table->string('email')->unique();  // Phone number to which OTP is sent
            $table->string('otp');  // OTP value
            $table->integer('attempts')->default(0);  // Number of attempts
            $table->timestamp('expires_at')->nullable(); // <-- this is your expression/expiration time
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
