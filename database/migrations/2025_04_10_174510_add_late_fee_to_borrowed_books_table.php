<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLateFeeToBorrowedBooksTable extends Migration
{
    public function up()
    {
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->decimal('late_fee', 8, 2)->default(0.00); // Store late fee in dollars (e.g., 5.50)
        });
    }

    public function down()
    {
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->dropColumn('late_fee');
        });
    }
}