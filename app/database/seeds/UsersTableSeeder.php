<?php

class UsersTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        User::truncate();

		$admin = User::create([
            'username' => 'admin',
            'displayname' => 'Website Administrator',
            'email' => 'admin@localhost.local',
            'password' => 'admin',
            'birthday' => '2000-' . date('m-d'),
            'is_female' => 0,
        ]);
        $admin->addRole(Role::ROLE_MASTER_ADMIN);

        $user = User::create([
            'username' => 'user',
            'displayname' => 'Website User',
            'email' => 'user@localhost.local',
            'password' => 'user',
            'birthday' => '2000-' . date('m-d'),
            'is_female' => 0,
        ]);
        $user->addRole(Role::ROLE_USER);
	}

}
