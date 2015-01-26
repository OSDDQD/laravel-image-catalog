<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ingredients', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->boolean('is_visible');
			$table->string('image')->nullable();

			$table->foreign('category_id')
				->references('id')->on('ingredients_categories')
				->onDelete('cascade');
		});

		Schema::create('ingredients_translations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ingredient_id')->unsigned();
			$table->string('title');
			$table->text('description')->nullable();
			$table->string('locale', 3)->index();

			$table->unique(['ingredient_id', 'locale']);
			$table->foreign('ingredient_id')
				->references('id')->on('ingredients')
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
		Schema::drop('ingredients_translations');
		Schema::drop('ingredients');
	}

}
