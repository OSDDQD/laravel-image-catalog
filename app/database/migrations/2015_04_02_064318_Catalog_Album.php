<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogAlbum extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalog_albums', function(Blueprint $table) {
			$table->increments('id');
			$table->boolean('is_visible')->nullable();
			$table->string('cover')->nullable();
		});

		Schema::create('catalog_albums_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('catalog_album_id')->unsigned();
			$table->string('title');
			$table->string('description');
			$table->string('locale', 3)->index();

			$table->unique(['catalog_album_id', 'locale'], 'catalog_album_id_locale_unique');
			$table->foreign('catalog_album_id', 'catalog_album_id_foreign')
			      ->references('id')->on('catalog_albums')
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
		Schema::drop('catalog_albums_translations');
		Schema::drop('catalog_albums');
	}

}
