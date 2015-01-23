<?php

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Role::truncate();

        Role::create([
            'name' => Role::ROLE_GUEST,
            'is_default' => true,
        ]);

        Role::create([
            'name' => Role::ROLE_USER,
            'is_default' => false,
        ]);

        Role::create([
            'name' => Role::ROLE_MASTER_ADMIN,
            'is_default' => false,
        ]);

	}

}