<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(TimesTableSeeder::class);
        $this->call(StudentTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(PeopleTableSeeder::class);
    }
}
