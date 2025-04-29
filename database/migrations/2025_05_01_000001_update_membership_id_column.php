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
            // Check if the foreign key exists before dropping
            $foreignKeys = $this->getForeignKeys('users');
            if (in_array('users_membership_id_foreign', $foreignKeys)) {
                $table->dropForeign(['membership_id']);
            }

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
            // Drop the modified membership_id column
            $table->dropColumn('membership_id');
        });

        Schema::table('users', function (Blueprint $table) {
            // Revert to the original membership_id (assuming it was a foreign key)
            $table->unsignedBigInteger('membership_id')->nullable()->after('email');
            $table->foreign('membership_id')->references('id')->on('memberships')->onDelete('set null');
        });
    }

    /**
     * Get all foreign keys for a table.
     *
     * @param string $table
     * @return array
     */
    private function getForeignKeys($table)
    {
        $connection = Schema::getConnection();
        $database = $connection->getDatabaseName();
        $foreignKeys = [];

        $result = $connection->select("
            SELECT CONSTRAINT_NAME
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = ?
            AND TABLE_NAME = ?
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$database, $table]);

        foreach ($result as $row) {
            $foreignKeys[] = $row->CONSTRAINT_NAME;
        }

        return $foreignKeys;
    }
}