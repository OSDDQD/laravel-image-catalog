<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IngredientsMenuAddFieldsNoveltyPopular extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('menu_items', function(Blueprint $table)
        {
            $table->integer('is_novelty')->unsigned()->default(0);
            $table->integer('is_popular')->unsigned()->default(0);
        });

        Schema::table('ingredients', function(Blueprint $table)
        {
            $table->integer('is_novelty')->unsigned()->default(0);
            $table->integer('is_popular')->unsigned()->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('ingredients', function(Blueprint $table) {
            $table->dropColumn('is_novelty');
            $table->dropColumn('is_popular');
        });

        Schema::table('menu_items', function(Blueprint $table) {
            $table->dropColumn('is_novelty');
            $table->dropColumn('is_popular');
        });
	}

}
