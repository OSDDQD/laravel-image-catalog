<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePizzasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pizzas', function(Blueprint $table) {
			$table->increments('id');
			$table->decimal('size', 10, 2)->nullable();
			$table->decimal('max_weight', 10, 2)->nullable();
			$table->boolean('is_visible')->nullable();
		});

		Schema::create('pizzas_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pizza_id')->unsigned();
			$table->string('title');
			$table->string('description')->nullable();
			$table->string('locale', 3)->index();

			$table->unique(['pizza_id', 'locale']);
			$table->foreign('pizza_id')
				->references('id')->on('pizzas')
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
		Schema::drop('pizzas_translations');
		Schema::drop('pizzas');
	}

}
