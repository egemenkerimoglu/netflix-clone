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
            $table->foreignIdFor(\App\Models\Serie::class);
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('overview')->nullable();
            $table->string('poster_path');
            $table->string('backdrop_path');
            $table->date('release_date');
            $table->string('trailer_url');
            $table->string('video_url');
            $table->integer('view_count')->default(0);
            $table->timestamps();
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
