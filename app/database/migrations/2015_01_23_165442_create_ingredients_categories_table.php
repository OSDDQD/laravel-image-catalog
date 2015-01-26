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
			$table->integer('ingredients_category_id')->unsigned();
			$table->string('title');
			$table->string('locale', 3)->index();

			$table->unique(['ingredients_category_id', 'locale'], 'ings_category_id_locale_unique');
			$table->foreign('ingredients_category_id', 'ings_category_id_foreign')
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
