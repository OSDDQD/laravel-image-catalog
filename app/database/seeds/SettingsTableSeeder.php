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
            'name' => 'twitter',
            'value' => 'https://www.twitter.com/',
            'is_editable' => true,
        ]);

        Setting::create([
            'name' => 'google',
            'value' => 'https://plus.google.com/',
            'is_editable' => true,
        ]);

        Setting::create([
            'name' => 'feedback_emails',
            'value' => '',
            'is_editable' => true,
        ]);

	}

}
