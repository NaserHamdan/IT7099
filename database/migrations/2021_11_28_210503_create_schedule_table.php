<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->string('SEC_TERM_CODE',6)->nullable(true);
            $table->string('SEC_COLLEGE',2)->nullable(true);
            $table->string('SEC_COURSE',9)->nullable(true);
            $table->string('SEC_SHORT_TITLE',30)->nullable(true);
            $table->string('SEC_LONG_TITLE',100)->nullable(true);
            $table->string('SEC_CRN',5)->nullable(true);
            $table->string('SEC_SECTION',3)->nullable(true);
            $table->string('SEC_LINK_IDENTIFIER',2)->nullable(true);
            $table->string('SEC_STATUS',1)->nullable(true);
            $table->decimal('SEC_BILLING_HRS')->nullable(true);
            $table->decimal('SEC_CREDIT_HOURS')->nullable(true);
            $table->string('SEC_GRADABLE',1)->nullable(true);
            $table->string('SEC_SELFSERVICE_AVAIL',1)->nullable(true);
            $table->string('SEC_EXCL_ATTENDANCE',1)->nullable(true);
            $table->decimal('SEC_CONTACT_HOURS')->nullable(true);
            $table->string('SEC_PART_OF_TERM',3)->nullable(true);
            $table->string('SEC_SCHEDULE_TYPE',3)->nullable(true);
            $table->decimal('SEC_WORKLOAD')->nullable(true);
            $table->string('SEC_GRADE_MODE',1)->nullable(true);
            $table->string('SEC_SESSION',2)->nullable(true);
            $table->string('SEC_START_TIME',4)->nullable(true);
            $table->string('SEC_END_TIME',4)->nullable(true);
            $table->string('SEC_WK_DAYS',13)->nullable(true);
            $table->decimal('SEC_HOURS_PER_WK',5,2)->nullable(true);
            $table->string('SEC_BUILDING',10)->nullable(true);
            $table->string('SEC_ROOM',10)->nullable(true);
            $table->string('SEC_TUTOR',4000)->nullable(true);
            $table->string('SEC_PRIMARY_TUTOR',1)->nullable(true);
            $table->string('SEC_OVERRIDE',1)->nullable(true);
            $table->decimal('SEC_MAX_EMROLLMENT',4)->nullable(true);
            $table->decimal('SEC_ENROLLED_STUDENTS')->nullable(true);
            $table->string('SEC_SYAAITM_EXISTS',1)->nullable(true);
            $table->string('SEC_CAPP_PREREQ_IND',1)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule');
    }
}
