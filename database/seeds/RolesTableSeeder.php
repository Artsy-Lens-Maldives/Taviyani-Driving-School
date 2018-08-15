<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "admin",
                "guard_name" => "web"
            ],
            [
                "name" => "student",
                "guard_name" => "web"
            ],
            [
                "name" => "instructor",
                "guard_name" => "web"
            ]
        ];
        DB::table('roles')->insert($data);
    }
}
