<?php

class SettingsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        Setting::truncate();

        Setting::create([
            'name' => 'facebook',
            'value' => 'https://www.facebook.com/',
            'is_editable' => true,
        ]);

        Setting::create([
            'name' => 'feedback_emails',
            'value' => '',
            'is_editable' => true,
        ]);

        Setting::create([
            'name' => 'top_slider',
            'value' => 'a:5:{i:0;b:0;i:1;b:0;i:2;b:0;i:3;b:0;i:4;b:0;}',
            'is_editable' => false,
        ]);
	}

}
