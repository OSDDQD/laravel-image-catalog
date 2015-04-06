<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryIdInAlbum extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('catalog_albums', function(Blueprint $table) {
            $table->tinyInteger('category_id')->unsigned()->after('position');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('catalog_albums', function(Blueprint $table) {
            $table->dropColumn('category_id');
        });
	}

}
