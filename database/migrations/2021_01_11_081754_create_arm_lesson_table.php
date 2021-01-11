<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArmLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arm_lesson', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('arm_id')->unsigned()->foreign('arm_id')->references('id')->on('arms');
            $table->integer('lesson_id')->unsigned()->foreign('lesson_id')->references('id')->on('lessons');
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
        Schema::dropIfExists('arm_lesson');
    }
}
