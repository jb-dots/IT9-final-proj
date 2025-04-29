<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierIdToStockHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('stock_histories', function (Blueprint $table) {
            // Add the foreign key constraint to the existing supplier_id column
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('stock_histories', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });
    }
}