<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_no')->nullable()->after('email');
            $table->string('address')->nullable()->after('contact_no');
            $table->string('profile_picture')->nullable()->after('address');
            $table->enum('role', ['admin', 'user'])->default('user')->after('profile_picture');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['contact_no', 'address', 'profile_picture', 'role']);
        });
    }
}