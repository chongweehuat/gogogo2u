<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebpagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('webpages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('code',30);
			$table->char('locale',12);
			$table->string('title');
			$table->text('body');
			$table->timestamps();
			$table->unique(['code', 'locale']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('webpages');
	}

}
