<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('programation_id');
            $table->date('date_course');
            $table->string('name');
            $table->string('last_name');
            $table->string('city_id');
            $table->string('email');
            $table->integer('state_id');
            $table->integer('zip_code');
            $table->string('telephone');
            $table->string('license');
            $table->string('license_issuing');
            $table->string('name_building');
            $table->string('last_name_building');
            $table->string('address_building');
            $table->string('city_id_building');
            $table->integer('state_id_building');
            $table->string('zip_code_building');
            $table->string('card_building');
            $table->string('date_expired_building');
            $table->string('security_code_building');
            $table->date('date_selected')->nullable();
            $table->integer('status_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('purchases');
    }

}
