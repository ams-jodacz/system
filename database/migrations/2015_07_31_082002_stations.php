<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Stations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Stations
        Schema::create('station_group', function($t) {
            $t->increments('station_group_id');
            $t->string('group_name', 45);
        });

		//Stations
        Schema::create('stations', function($t) {
            $t->increments('station_id');
            $t->string('ip', 45)->unique();
            $t->string('name', 45);
            $t->string('description', 45);
            $t->enum('status', ['In', 'Out']);
            $t->integer('station_group_id')->unsigned();
            $t->foreign('station_group_id')->references('station_group_id')->on('station_group');
            $t->boolean('enable_status')->default(true);
            $t->boolean('station_status')->default(false);
            $t->boolean('restart_status')->default(false);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stations');
		Schema::drop('station_group');
	}

}
