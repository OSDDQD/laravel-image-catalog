<?php

// Composer: "fzaninotto/faker": "v1.3.0"

class MenuCategoryTableSeeder extends Seeder {

	public function run()
	{

		foreach(range(1, 10) as $index)
		{
			Menu::create([

			]);
		}
	}

}