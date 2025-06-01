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
        Schema::create('admin_refresh_tokens', function (Blueprint $table) {
            $table->id();
            $table->text('token')->unique()->nullable();
            $table->foreignId('user_id')->constrained('admins')->onDelete('cascade');
            $table->bigInteger('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_refresh_tokens');
    }
};
