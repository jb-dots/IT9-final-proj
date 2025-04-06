<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDueDateToBorrowedBooksTable extends Migration
{
    public function up()
    {
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->timestamp('due_date')->nullable()->after('borrowed_at');
        });
    }

    public function down()
    {
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->dropColumn('due_date');
        });
    }
}