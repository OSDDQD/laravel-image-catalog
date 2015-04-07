<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogImage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalog_images', function(Blueprint $table) {
			$table->increments('id');
			$table->boolean('is_visible')->nullable();
			$table->integer('album_id')->unsigned();
		});

		Schema::create('catalog_images_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('image_id')->unsigned();
			$table->string('title');
			$table->string('description');
			$table->string('locale', 3)->index();

			$table->unique(['image_id', 'locale'], 'image_id_locale_unique');
			$table->foreign('image_id', 'image_id_foreign')
			      ->references('id')->on('catalog_images')
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
		Schema::drop('catalog_images_translations');
		Schema::drop('catalog_images');
	}

}
