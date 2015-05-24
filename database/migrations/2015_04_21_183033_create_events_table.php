<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('business_id');
			$table->integer('language_id');
			$table->integer('album_id');
			$table->dateTime('date_start');
			$table->dateTime('date_end');
			$table->string('title');
			$table->text('body');
			$table->string('name');
			$table->string('jobtitle');
			$table->string('address');
			$table->string('hpno');
			$table->string('telno');
			$table->integer('wechat_image_id');
			$table->string('wechat_url');
			$table->string('email');
			$table->string('website');
			$table->string('facebook');
			$table->integer('gps_id');
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
		Schema::drop('events');
	}

}
