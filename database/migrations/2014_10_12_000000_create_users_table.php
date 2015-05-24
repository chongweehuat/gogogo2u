<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
				  $table->string('name');
				  $table->string('username')->nullable();
				  $table->string('email')->unique();
				  $table->string('avatar');
				  $table->string('timezone');
				  $table->boolean('confirmed')->default(0);
				  $table->string('confirmation_code')->nullable();
			$table->string('password', 60);
			$table->rememberToken();
				  $table->string('affiliate_code');
				  $table->integer('parent_id');
			$table->integer('role_id');
			$table->integer('biz_count');
			$table->timestamps();
			$table->index('confirmation_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
