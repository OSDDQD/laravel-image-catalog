<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('menu_items', function(Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('position')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->boolean('is_visible');
            $table->string('image')->nullable();

            $table->foreign('category_id')
                ->references('id')->on('menu_categories')
                ->onDelete('cascade');
        });

        Schema::create('menu_items_translations', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('locale', 3)->index();

            $table->unique(['item_id', 'locale']);
            $table->foreign('item_id')
                ->references('id')->on('menu_items')
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
        Schema::drop('menu_items_translations');
        Schema::drop('menu_items');
	}

}
