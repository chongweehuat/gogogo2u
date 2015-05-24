<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainpagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mainpages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('business_id');
			$table->integer('language_id');
			$table->integer('album_id');
			$table->string('title');
			$table->string('abstract');
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
		Schema::drop('mainpages');
	}

}
