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
        Schema::create('genre_movie', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('movie_id');
            $table->unsignedBiginteger('genre_id');
            $table->foreign('movie_id')->references('id')
                ->on('movies')->onDelete('cascade');
            $table->foreign('genre_id')->references('id')
                ->on('genres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres');
    }
};
