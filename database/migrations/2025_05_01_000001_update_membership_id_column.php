<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMembershipIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraint first if exists
            $table->dropForeign(['membership_id']);
            // Drop existing membership_id column
            $table->dropColumn('membership_id');
        });

        Schema::table('users', function (Blueprint $table) {
            // Add membership_id as string and unique
            $table->string('membership_id')->unique()->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('membership_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('membership_id')->nullable()->after('email');
        });
    }
}
