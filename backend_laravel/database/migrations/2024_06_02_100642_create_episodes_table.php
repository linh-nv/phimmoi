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
        Schema::create('episodes', function (Blueprint $table) {
            $table->id();
            $table->string('movie_slug');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('link_embed')->nullable();
            $table->timestamps();

            $table->foreign('movie_slug')->references('slug')->on('movies')->onDelete('cascade');
            $table->unique(['movie_slug', 'slug'], 'movie_slug_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('episodes');
    }
};
