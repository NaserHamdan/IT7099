<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvigiliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invigiliations', function (Blueprint $table) {
            $table->foreignId('exam_id')->constrained('exams')->references('exam_id');
            $table->foreignId('tutor_id')->constrained('tutors')->references('tutor_id');
            $table->char('invigilation_type',1);
            $table->string('room');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invigiliations');
    }
}
