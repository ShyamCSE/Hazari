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
   Schema::create('device_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->string('device_id')->nullable(); // Optional, if used
    $table->string('device_name')->nullable(); // ✅ Add this
    $table->string('platform')->nullable(); // ✅ Add this
    $table->string('browser')->nullable(); // ✅ Add this
    $table->ipAddress('ip_address')->nullable();
    $table->timestamp('last_login_at')->nullable(); // ✅ Add this
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_logs');
    }
};
