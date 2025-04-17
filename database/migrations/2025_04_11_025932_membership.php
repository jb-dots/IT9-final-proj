<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create memberships table
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('issued_at')->nullable();
            $table->timestamps();
        });

        // Update users table
        Schema::table('users', function (Blueprint $table) {
            // Only drop membership_id if it exists
            if (Schema::hasColumn('users', 'membership_id')) {
                $table->dropColumn('membership_id');
            }
            // Add foreign key to memberships table
            $table->foreignId('membership_id')->nullable()->constrained('memberships')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Reverse changes to users table
        Schema::table('users', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['membership_id']);
            $table->dropColumn('membership_id');
            // Only add string column if needed (optional, based on your original schema)
            $table->string('membership_id')->nullable();
        });

        // Drop memberships table
        Schema::dropIfExists('memberships');
    }
};