<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToVideosTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('videos', 'series_id')) {
            Schema::table('videos', function (Blueprint $table) {
                $table->foreignId('series_id')->nullable()->constrained('series')->nullOnDelete();
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('videos', 'series_id')) {
            Schema::table('videos', function (Blueprint $table) {
                $table->dropForeign(['series_id']);
                $table->dropColumn('series_id');
            });
        }
    }
}