<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransportfeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportfees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_id')->nullable();
            $table->string('location_id')->nullable();
            $table->string('type')->nullable();
            $table->string('date')->nullable();
            $table->string('paid')->nullable();
            $table->string('total')->nullable();
            $table->string('status')->nullable();
            $table->integer('slipTaken')->default('0')->nullable();
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
        Schema::dropIfExists('transportfees');
    }
}
