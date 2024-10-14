<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNewFaceIdColumnInNewFaceIdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('new_face_id', function (Blueprint $table) {
            // Change new_face_id column type to varchar without a limit
            $table->string('new_face_id', 5000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_face_id', function (Blueprint $table) {
            // Revert the new_face_id column type back to integer
            $table->integer('new_face_id')->change();
        });
    }
}
