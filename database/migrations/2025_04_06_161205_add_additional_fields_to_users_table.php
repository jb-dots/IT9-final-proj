<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add contact_no if it doesn't exist
            if (!Schema::hasColumn('users', 'contact_no')) {
                $table->string('contact_no')->nullable()->after('email');
            }

            // Add address if it doesn't exist
            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('contact_no');
            }

            // Add profile_picture if it doesn't exist
            if (!Schema::hasColumn('users', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('address');
            }

            // Skip adding role since it already exists
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop columns only if they exist
            if (Schema::hasColumn('users', 'contact_no')) {
                $table->dropColumn('contact_no');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('users', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }
        });
    }
}