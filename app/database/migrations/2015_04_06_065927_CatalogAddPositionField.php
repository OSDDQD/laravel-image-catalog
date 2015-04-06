<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogAddPositionField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('catalog_categories', function(Blueprint $table) {
			$table->tinyInteger('position')->unsigned()->after('id');
		});

		Schema::table('catalog_albums', function(Blueprint $table) {
			$table->tinyInteger('position')->unsigned()->after('id');
		});

		Schema::table('catalog_images', function(Blueprint $table) {
			$table->tinyInteger('position')->unsigned()->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('catalog_categories', function(Blueprint $table) {
			$table->dropColumn('position');
		});

		Schema::table('catalog_albums', function(Blueprint $table) {
			$table->dropColumn('position');
		});

		Schema::table('catalog_images', function(Blueprint $table) {
			$table->dropColumn('position');
		});
	}

}
