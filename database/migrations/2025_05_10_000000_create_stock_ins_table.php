<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInsTable extends Migration
{
    public function up()
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->string('performed_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_ins');
    }
}
