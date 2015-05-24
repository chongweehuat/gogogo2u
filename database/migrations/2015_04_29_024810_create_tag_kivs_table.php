<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagKivsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_kivs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('code',30);
			$table->char('module',30);
			$table->integer('module_id');
			$table->timestamps();
			$table->index('module_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tag_kivs');
	}

}
