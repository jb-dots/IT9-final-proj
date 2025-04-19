<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class CreatePublishersTable extends Migration
   {
       public function up()
       {
           Schema::create('publishers', function (Blueprint $table) {
               $table->id();
               $table->string('name')->unique();
               $table->timestamps();
           });

           Schema::table('books', function (Blueprint $table) {
               $table->foreignId('publisher_id')->nullable()->constrained()->onDelete('set null')->after('author');
           });
       }

       public function down()
       {
           Schema::table('books', function (Blueprint $table) {
               $table->dropForeign(['publisher_id']);
               $table->dropColumn('publisher_id');
           });

           Schema::dropIfExists('publishers');
       }
   }