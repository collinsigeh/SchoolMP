<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewstaffdatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newstaffdatas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('staff_id');
            $table->text('my_classes');
            $table->text('my_subjects');
            $table->enum('status', ['Pending', 'Completed']);
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
        Schema::dropIfExists('newstaffdatas');
    }
}
