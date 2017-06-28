<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('schedules_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id');
            $table->integer('day');
            $table->integer('course_id');
            $table->time('hour');
            $table->time('hour_end');
            $table->integer('duration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('schedules_detail');
    }

}
