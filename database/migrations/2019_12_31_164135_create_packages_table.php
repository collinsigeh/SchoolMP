<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->string('name');
            $table->string('image');
            $table->string('student_limit', 25);
            $table->string('term_limit', 25);
            $table->string('day_limit', 25);
            $table->enum('price_type', ['Per-student', 'Per-package']);
            $table->decimal('price', 10, 2);
            $table->enum('status', ['Available', 'NOT Available']);
            $table->integer('created_by');
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
        Schema::dropIfExists('packages');
    }
}
