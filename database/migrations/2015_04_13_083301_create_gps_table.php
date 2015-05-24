<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGpsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gps', function(Blueprint $table)
		{
			$table->increments('id');
			$table->decimal('lat', 7, 4);
			$table->decimal('lng', 8, 4);
			$table->char('address', 255);
			$table->string('gps_address', 600);
			$table->timestamps();
			$table->index(['lat','lng']);
			$table->index('address');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gps');
	}

}
