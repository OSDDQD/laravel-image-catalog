<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngredientsCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ingredients_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->boolean('is_visible')->nullable();
		});

		Schema::create('ingredients_categories_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->string('title');
			$table->string('locale', 3)->index();

			$table->unique(['category_id', 'locale']);
			$table->foreign('category_id')
				->references('id')->on('ingredients_categories')
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
		Schema::drop('ingredients_categories_translations');
		Schema::drop('ingredients_categories');
	}

}
