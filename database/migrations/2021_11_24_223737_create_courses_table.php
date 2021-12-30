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
            $table->id('course_id')->autoIncrement();
            $table->string('course_code');
            $table->string('course_title');
            $table->integer('number_of_students')->default(0);
            $table->string('marking_diffucality')->default("Low");
            $table->string('course_coordinator')->default('NA');
            $table->char('have_exam',1)->default("N");
            $table->boolean('reviewed')->default(false);
            $table->foreignId('year_id')->constrained('years')->references("year_id");
            $table->foreignId('major_id')->constrained('majors')->references("major_id");
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
