<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranLanguageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tran_language', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('translation_id');
			$table->integer('language_id');
			$table->string('content');
			$table->index(['translation_id','language_id']);
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
		Schema::drop('tran_language');
	}

}
