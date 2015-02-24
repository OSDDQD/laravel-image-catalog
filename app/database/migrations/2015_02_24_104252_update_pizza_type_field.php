<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePizzaTypeField extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        DB::statement('ALTER TABLE `pizzas` MODIFY `is_prepared` INTEGER UNSIGNED NOT NULL DEFAULT 0;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        DB::statement('ALTER TABLE `pizzas` MODIFY `is_prepared` INTEGER UNSIGNED NULL;');
	}

}
