<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTablesStructure extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username', 32)->unique();
			$table->string('displayname', 255);
			$table->string('email')->unique();
			$table->string('password');
			$table->date('birthday');
			$table->boolean('is_female');
			$table->boolean('active')->default(1);
			$table->string('remember_token', 100);

			$table->timestamps();
		});

		Schema::create('roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->boolean('is_default');
		});

		Schema::create('users_roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('role_id')->unsigned()->index();
			$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
		});

		Schema::create('settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 32);
			$table->string('locale', 3)->nullable()->index();
			$table->string('value');
			$table->boolean('is_editable');
			$table->enum('type', ['text', 'localized', 'serialized']);

			$table->unique(['name', 'locale'], 'settings_name_locale_unique');
		});

		Schema::create('password_reminders', function(Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('password_reminders');
		Schema::drop('settings');
		Schema::drop('users_roles');
		Schema::drop('roles');
		Schema::drop('users');
	}

}
