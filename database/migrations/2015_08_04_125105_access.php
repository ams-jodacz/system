<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Access extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Access Table
        Schema::create('station_access', function($t){
        	$t->increments('access_id');
            $t->integer('class_group_id')->unsigned();
            $t->foreign('class_group_id')->references('class_group_id')->on('classification_group');
            $t->integer('station_group_id')->unsigned();
            $t->foreign('station_group_id')->references('station_group_id')->on('station_group');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('station_access');
	}

}
