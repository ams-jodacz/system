<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Logs extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Tags Table
        Schema::create('time_logs', function($t){
            $t->integer('station_id')->unsigned();
            $t->foreign('station_id')->references('station_id')->on('stations');
            $t->string('id_number',45);
            $t->dateTime('date_time');
        });

		//Error Log Table
        Schema::create('error_logs', function($t){
        	$t->increments('error_log_id');
            $t->string('ip',45);
            $t->string('msg',100);
            $t->dateTime('date_time');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('time_logs');
		Schema::drop('error_logs');
	}

}
