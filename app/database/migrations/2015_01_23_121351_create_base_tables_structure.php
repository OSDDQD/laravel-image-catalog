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

		Schema::create('materials', function(Blueprint $table)
		{
			$table->increments('id');
			$table->enum('type', ['page', 'news', 'action', 'announcement'])->nullable();
			$table->boolean('is_visible')->nullable();
			$table->string('image')->nullable();
			$table->timestamps();
		});

		Schema::create('materials_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('material_id')->unsigned();
			$table->string('title');
			$table->longText('text');
			$table->string('locale', 3)->index();

			$table->unique(['material_id', 'locale']);
			$table->foreign('material_id')
				->references('id')->on('materials')
				->onDelete('cascade');
		});

		Schema::create('pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('path')->nullable();
			$table->integer('parent_id')->unsigned()->nullable();
			$table->integer('level')->default(0);
			$table->smallInteger('position')->unsigned();
			$table->string('slug')->unique();
			$table->enum('show_title', ['none', 'material', 'page'])->default('page');
			$table->enum('content_type', ['material', 'html', 'link'])->nullable();
			$table->text('content')->nullable();
			$table->string('template');
			$table->boolean('is_visible');
			$table->boolean('is_home');
			$table->timestamps();

			$table->index(array('path', 'parent_id', 'level'));
			$table->foreign('parent_id')
				->references('id')->on('pages')
				->onDelete('cascade');
		});

		Schema::create('pages_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('page_id')->unsigned();
			$table->string('title');
			$table->string('keywords')->nullable();
			$table->string('description')->nullable();
			$table->string('locale', 3)->index();

			$table->unique(['page_id', 'locale']);
			$table->foreign('page_id')
				->references('id')->on('pages')
				->onDelete('cascade');
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

		Schema::create('components', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name')->unique();
			$table->string('controller', 64);
			$table->string('action', 48);
			$table->string('params')->nullable();

			$table->unique(['controller', 'action', 'params'], 'components_controller_actions_params_unique');
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

		Schema::create('guestbook', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('displayname')->nullable();
			$table->text('text');
			$table->string('ip', 45);
			$table->boolean('is_visible')->default(true);
			$table->timestamps();

			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade');
		});

		Schema::create('password_reminders', function(Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at');
		});

		Schema::create('menus', function(Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
		});

		Schema::create('menus_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('menu_id')->unsigned();
			$table->string('title');
			$table->string('locale', 3)->index();

			$table->unique(['menu_id', 'locale']);
			$table->foreign('menu_id')
				->references('id')->on('menus')
				->onDelete('cascade');
		});

		Schema::table('pages', function(Blueprint $table) {
			$table->integer('menu_id')->unsigned()->nullable()->after('path');

			$table->foreign('menu_id')
				->references('id')->on('menus')
				->onDelete('cascade');
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
		Schema::drop('guestbook');
		Schema::drop('settings');
		Schema::drop('components');
		Schema::drop('users_roles');
		Schema::drop('roles');
		Schema::drop('menus_translations');
		Schema::drop('menus');
		Schema::drop('pages_translations');
		Schema::drop('pages');
		Schema::drop('materials_translations');
		Schema::drop('materials');
		Schema::drop('users');
	}

}
