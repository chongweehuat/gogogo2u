<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubpagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subpages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('business_id');
			$table->integer('language_id');
			$table->integer('album_id');
			$table->string('title');
			$table->char('pagetype',30);
			$table->text('body');
			$table->index('business_id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subpages');
	}

}
