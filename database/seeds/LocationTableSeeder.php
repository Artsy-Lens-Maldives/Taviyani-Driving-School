<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'name' => 'Male',
            'code' => 'tds'
        ]);

        DB::table('locations')->insert([
            'name' => 'Hulhumale',
            'code' => 'tdsh'
        ]);
    }
}
