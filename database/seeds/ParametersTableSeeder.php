<?php

use Illuminate\Database\Seeder;

class ParametersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('parameters')->insert([
            'description' => "Days to show",
            'value' => 1,
            'group' => 'show',
            'code' => 1,
        ]);

        DB::table('parameters')->insert([
            'description' => "monday",
            'group' => 'days',
            'code' => 1,
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "tuesday",
            'group' => 'days',
            'code' => 2,
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "wednesday",
            'group' => 'days',
            'code' => 3,
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "thurday",
            'code' => 4,
            'group' => 'days',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "friday",
            'code' => 5,
            'group' => 'days',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "saturday",
            'code' => 6,
            'group' => 'days',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "sunday",
            'code' => 7,
            'group' => 'days',
            'value' => 0,
        ]);
        
        DB::table('parameters')->insert([
            'description' => "january",
            'code' => 1,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "february",
            'code' => 2,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "march",
            'code' => 3,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "april",
            'code' => 4,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "may",
            'code' => 5,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "june",
            'code' => 6,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "july",
            'code' => 7,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "august",
            'code' => 8,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "september",
            'code' => 9,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "october",
            'code' => 10,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "november",
            'code' => 11,
            'group' => 'months',
            'value' => 0,
        ]);
        DB::table('parameters')->insert([
            'description' => "december",
            'code' => 12,
            'group' => 'months',
            'value' => 0,
        ]);
        
        
    }

}
