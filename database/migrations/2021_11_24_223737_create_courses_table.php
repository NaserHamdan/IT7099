<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id('course_id');
            $table->string('course_code');
            $table->string('course_title');
            $table->integer('number_of_students');
            $table->string('marking_diffucality');
            $table->string('course_coordinator');
            $table->char('have_exam');
            $table->foreignId('year_id')->constrained('years')->references("year_id");
            $table->foreignId('major_id')->constrained('majors')->references("major_id");
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
        Schema::dropIfExists('courses');
    }
}
