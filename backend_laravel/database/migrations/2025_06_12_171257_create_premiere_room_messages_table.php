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
        Schema::create('premiere_room_messages', function (Blueprint $table) {
            $table->id();
            $table->uuid('premiere_room_code');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->enum('type', ['text', 'system', 'emoji'])->default('text');
            $table->json('metadata')->nullable(); // Lưu thêm thông tin như emoji, mentions
            $table->boolean('is_deleted')->default(false);
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['premiere_room_code', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('created_at');

            // Foreign keys
            $table->foreign('premiere_room_code')
                ->references('code')
                ->on('premiere_rooms')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premiere_room_messages');
    }
};
