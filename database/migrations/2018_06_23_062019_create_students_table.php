<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vehicle_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('user_id')->nullable();
            
            $table->string('photo_url')->nullable();
            $table->string('name')->nullable();
            $table->string('id_card')->nullable();
            $table->string('phone')->nullable();
            $table->string('p_address')->nullable();
            $table->string('c_address')->nullable();
            $table->string('dateofbirth')->nullable();
            $table->string('gender')->nullable();
            $table->string('license_no')->nullable();
            $table->string('theory_count')->default('0')->nullable();
            $table->string('driving_count')->default('0')->nullable();
            
            $table->string('rate')->nullable();
            $table->string('remarks')->nullable();
            $table->string('finished_at')->nullable();
            $table->string('license_url')->nullable();
            $table->string('form_url')->nullable();

            $table->string('month')->nullable();
            $table->string('year')->nullable();
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
        Schema::dropIfExists('students');
    }
}
