<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pizzas', function(Blueprint $table) {
			$table->tinyInteger('position')->unsigned()->after('id');
		});

		Schema::table('ingredients_categories', function(Blueprint $table) {
			$table->tinyInteger('position')->unsigned()->after('id');
		});

		Schema::table('ingredients', function(Blueprint $table) {
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
		Schema::table('pizzas', function(Blueprint $table) {
			$table->dropColumn('position');
		});

		Schema::table('ingredients_categories', function(Blueprint $table) {
			$table->dropColumn('position');
		});

		Schema::table('ingredients', function(Blueprint $table) {
			$table->dropColumn('position');
		});
	}

}
