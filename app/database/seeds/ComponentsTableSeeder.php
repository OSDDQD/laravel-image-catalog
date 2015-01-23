<?php

class ComponentsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        Component::truncate();

        Component::create([
            'name' => 'feedback',
            'controller' => 'FeedbackController',
            'action' => 'form',
            'params' => '',
        ]);

        Component::create([
            'name' => 'guestbook',
            'controller' => 'GuestbookController',
            'action' => 'display',
            'params' => '',
        ]);

        Component::create([
            'name' => 'latestnews',
            'controller' => 'MaterialsController',
            'action' => 'news',
            'params' => 'limit:5',
        ]);

        Component::create([
            'name' => 'news',
            'controller' => 'MaterialsController',
            'action' => 'news',
            'params' => '',
        ]);
	}

}
