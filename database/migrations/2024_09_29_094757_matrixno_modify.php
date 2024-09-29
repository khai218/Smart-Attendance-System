<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing 'matrixno' column
            $table->dropColumn('matrixno');
        });

        Schema::table('users', function (Blueprint $table) {
            // Recreate the 'matrixno' column with a unique constraint
            $table->string('matrixno')->unique()->after('name'); // Adjust the position if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
