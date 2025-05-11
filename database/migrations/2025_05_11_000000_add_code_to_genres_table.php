<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodeToGenresTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('genres', 'code')) {
            Schema::table('genres', function (Blueprint $table) {
                $table->string('code', 5)->nullable()->after('name');
            });
        }
    }

    public function down()
    {
        Schema::table('genres', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
