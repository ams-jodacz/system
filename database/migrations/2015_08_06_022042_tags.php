<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tags extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Tags Table
        Schema::create('tags', function($t){
        	$t->increments('id');
            $t->string('id_number',45)->unique();
            $t->foreign('id_number')->references('id_number')->on('members');
            $t->string('tag',45)->unique();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tags');
	}

}
