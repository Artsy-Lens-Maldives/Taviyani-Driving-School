<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_id')->nullable();
            $table->string('score')->nullable();
            $table->string('time_left')->nullable();
            $table->timestamps();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('quiz_attempts')->default('0')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_histories');

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('quiz_attempts');
        });
    }
}
