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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('origin_name');
            $table->text('content');
            $table->tinyInteger('type');
            $table->tinyInteger('status');
            $table->string('poster_url');
            $table->string('thumb_url');
            $table->boolean('is_copyright')->default(false);
            $table->boolean('sub_docquyen')->default(false);
            $table->boolean('chieurap')->default(false);
            $table->string('trailer_url')->nullable();
            $table->string('time')->nullable();
            $table->string('episode_current')->nullable();
            $table->integer('episode_total')->nullable();
            $table->string('quality')->nullable();
            $table->string('lang')->nullable();
            $table->string('notify')->nullable();
            $table->string('showtimes')->nullable();
            $table->integer('year')->nullable();
            $table->bigInteger('view')->default(0);
            $table->text('actor')->nullable();
            $table->text('director')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
