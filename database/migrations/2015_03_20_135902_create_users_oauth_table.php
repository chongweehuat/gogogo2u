<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersOauthTable extends Migration {

	public function up()
	{
		Schema::create('users_oauth', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->string('provider');
			$table->string('provider_user_id')->unique();
		});
	}

	public function down()
	{
		Schema::drop('users_oauth');
	}
}