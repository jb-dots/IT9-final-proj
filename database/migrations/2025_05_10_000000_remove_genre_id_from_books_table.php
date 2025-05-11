<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveGenreIdFromBooksTable extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            // Drop foreign key by column name
            $table->dropForeign(['genre_id']);
            // Drop the column
            $table->dropColumn('genre_id');
        });
    }

    public function down()
    {
        // Commented out to avoid duplicate column error during migration refresh rollback
        /*
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedBigInteger('genre_id')->nullable();
            // foreign key constraint is omitted to prevent rollback errors
        });
        */
    }
}
