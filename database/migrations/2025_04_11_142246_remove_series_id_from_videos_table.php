<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSeriesIdFromVideosTable extends Migration
{
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['series_id']);
            $table->dropColumn('series_id');
        });
    }

    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->foreignId('series_id')->nullable()->constrained()->onDelete('set null');
        });
    }
}