<?php

use Illuminate\Database\Seeder;

class LocationsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
       DB::table('locations')->insert([
            'description' => "test locations",
            'address' => "test address",
            'order' => 1
        ]);
    }

}
