<?php

use Illuminate\Database\Seeder;
use Flynsarmy\CsvSeeder\CsvSeeder;

class PeopleTableSeeder extends CsvSeeder
{
    public function __construct()
	{
		$this->table = 'people';
		$this->filename = base_path().'/database/sqls/people.csv';
	}

	public function run()
	{
		// Recommended when importing larger CSVs
		DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		DB::table($this->table)->truncate();

		parent::run();
	}
}
