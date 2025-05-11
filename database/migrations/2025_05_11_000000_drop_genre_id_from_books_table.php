<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropGenreIdFromBooksTable extends Migration
{
    public function up()
    {
        // Commented out to avoid dropping foreign key and column that may have been removed already
        /*
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['genre_id']);
            $table->dropColumn('genre_id');
        });
        */
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->foreignId('genre_id')->constrained('genres')->onDelete('cascade');
        });
    }
}
