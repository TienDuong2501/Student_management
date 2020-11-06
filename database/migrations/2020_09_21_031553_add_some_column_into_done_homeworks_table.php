<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnIntoDoneHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('done_homeworks', function (Blueprint $table) {
            $table->string('original_name');
            $table->text('description');
            $table->text('saved_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('done_homeworks', function (Blueprint $table) {
            $table->dropColumn(['original_name', 'saved_path', 'description']);
        });
    }
}
