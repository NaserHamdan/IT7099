<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsLabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams_labs', function (Blueprint $table) {
            $table->foreignId('lab_id')->constrained('labs')->references('lab_id')->onDelete('cascade');
            $table->foreignId('exam_id')->constrained('exams')->references('exam_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams_labs');
    }
}
