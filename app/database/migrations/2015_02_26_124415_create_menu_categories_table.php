<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('menu_categories', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('position')->unsigned();
            $table->boolean('is_visible')->nullable();
        });

        Schema::create('menu_categories_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('menu_category_id')->unsigned();
            $table->string('title');
            $table->string('locale', 3)->index();

            $table->unique(['menu_category_id', 'locale'], 'menu_category_id_locale_unique');
            $table->foreign('menu_category_id', 'menu_category_id_foreign')
                ->references('id')->on('menu_categories')
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
        Schema::drop('menu_categories_translations');
        Schema::drop('menu_categories');
	}

}
