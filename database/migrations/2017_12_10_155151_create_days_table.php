<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDaysTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->integer('number_week');
            $table->date('date');
            $table->integer('is_festive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('days');
    }

}
