<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassteachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classteachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('term_id');
            $table->integer('arm_id');
            $table->enum('type',  ['Class Teacher', 'Assistant Class Teacher']);
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classteachers');
    }
}
