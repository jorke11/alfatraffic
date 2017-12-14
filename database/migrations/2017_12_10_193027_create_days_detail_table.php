<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaysDetailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('days_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day_id');
            $table->integer('course_id');
            $table->integer('location_id');
            $table->date('date');
            $table->time('hour');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('days_detail');
    }

}
