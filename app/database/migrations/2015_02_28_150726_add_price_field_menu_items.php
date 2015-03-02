<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPriceFieldMenuItems extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('menu_items', function(Blueprint $table)
        {
            $table->decimal('price', '10', '2')->default(0);
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('menu_items', function(Blueprint $table) {
            $table->dropColumn('price');
        });
	}

}
