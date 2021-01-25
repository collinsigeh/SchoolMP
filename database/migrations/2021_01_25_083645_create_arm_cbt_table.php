<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArmCbtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arm_cbt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('arm_id')->unsigned()->foreign('arm_id')->references('id')->on('arms');
            $table->integer('cbt_id')->unsigned()->foreign('cbt_id')->references('id')->on('cbts');
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
        Schema::dropIfExists('arm_cbt');
    }
}
