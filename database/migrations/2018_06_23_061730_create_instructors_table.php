<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('user_id')->nullable();
            
            $table->string('photo_url')->default('/user.png')->nullable();

            $table->string('category')->nullable();
            
            $table->string('name')->nullable();
            $table->string('idcardno')->nullable();
            $table->string('phone')->nullable();
            $table->string('p_address')->nullable();
            $table->string('c_address')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();

            $table->string('license_no')->nullable();
            $table->string('license_expiry')->nullable();
            
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
        Schema::dropIfExists('instructors');
    }
}
