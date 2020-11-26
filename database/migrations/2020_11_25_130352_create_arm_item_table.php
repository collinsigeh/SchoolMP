<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArmItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arm_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('arm_id')->unsigned()->foreign('arm_id')->references('id')->on('arms');
            $table->integer('item_id')->unsigned()->foreign('item_id')->references('id')->on('items');
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
        Schema::dropIfExists('arm_item');
    }
}
