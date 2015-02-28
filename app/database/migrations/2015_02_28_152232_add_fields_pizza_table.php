<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsPizzaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('pizzas', function(Blueprint $table)
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
        Schema::table('pizzas', function(Blueprint $table) {
            $table->dropColumn('is_novelty');
            $table->dropColumn('is_popular');
        });
	}

}
