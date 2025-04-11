<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_default')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->text('description')->nullable();
            $table->string('url');
            $table->foreignId('previous_id')->nullable()->constrained('videos')->nullOnDelete();
            $table->foreignId('next_id')->nullable()->constrained('videos')->nullOnDelete();
            $table->foreignId('series_id')->nullable()->constrained('series')->nullOnDelete(); // Add this line
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
