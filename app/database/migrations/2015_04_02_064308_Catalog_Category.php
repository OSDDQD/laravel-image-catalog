<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogCategory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalog_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->boolean('is_visible')->nullable();
			$table->string('image')->nullable();
		});

		Schema::create('catalog_categories_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('catalog_category_id')->unsigned();
			$table->string('title');
			$table->string('description');
			$table->string('locale', 3)->index();

			$table->unique(['catalog_category_id', 'locale'], 'catalog_category_id_locale_unique');
			$table->foreign('catalog_category_id', 'catalog_category_id_foreign')
			      ->references('id')->on('catalog_categories')
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
		Schema::drop('catalog_categories_translations');
		Schema::drop('catalog_categories');
	}

}
