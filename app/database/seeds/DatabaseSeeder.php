<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        DB::statement("SET FOREIGN_KEY_CHECKS=0;");

        $this->call('RolesTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('ComponentsTableSeeder');
        $this->call('SettingsTableSeeder');
        $this->call('MaterialsTableSeeder');
        $this->call('PagesTableSeeder');
        $this->call('GuestbookTableSeeder');

        DB::statement("SET FOREIGN_KEY_CHECKS=1;");
	}

}
