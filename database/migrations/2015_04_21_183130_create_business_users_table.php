<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('business_users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('business_id');
			$table->integer('user_id');
			$table->char('role',30);
			$table->index('business_id');
			$table->index('user_id');
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
		Schema::drop('business_users');
	}

}
