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

        Component::create([
            'name' => 'latestnews_small',
            'controller' => 'MaterialsController',
            'action' => 'news',
            'params' => 'limit:2|mode:small|template:materials.partials.news_small',
        ]);

        Component::create([
            'name' => 'user_recipes',
            'controller' => 'Pizza\RecipesController',
            'action' => 'show',
            'params' => 'limit:4|type:preview|sort:rating',
        ]);

        Component::create([
            'name' => 'latestnews_additional',
            'controller' => 'MaterialsController',
            'action' => 'news',
            'params' => 'limit:4|type:additional|mode:small|template:materials.partials.news_additional',
        ]);
	}

}
