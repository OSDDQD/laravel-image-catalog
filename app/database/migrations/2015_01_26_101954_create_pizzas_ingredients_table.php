<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePizzasIngredientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pizzas_ingredients', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('pizza_id')->unsigned();
			$table->integer('ingredient_id')->unsigned();
			$table->decimal('price', 10, 2)->nullable();
			$table->decimal('weight', 10, 2)->nullable();
			$table->integer('max_quantity')->nullable();

			$table->foreign('pizza_id')
				->references('id')->on('pizzas')
				->onDelete('cascade');
			$table->foreign('ingredient_id')
				->references('id')->on('ingredients')
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
		Schema::drop('pizzas_ingredients');
	}

}
