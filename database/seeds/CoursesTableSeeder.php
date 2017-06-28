<?php

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'description' => "test course",
            'value' => 1000,
            'order' => 1,
            'dui' => false,
        ]);
        DB::table('courses')->insert([
            'description' => "test course dui",
            'value' => 1000,
            'order' => 2,
            'dui' => true,
        ]);
    }
}
