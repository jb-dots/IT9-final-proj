<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToGenresCode extends Migration
{
    public function up()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->unique('code');
        });
    }

    public function down()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->dropUnique(['code']);
        });
    }
}
