<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Attendance extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Attendance Group Name
        Schema::create('attendance_group', function($t){
            $t->increments('attendance_group_id');
            $t->string('group_name',45);
        });

        //Attendance Access
        Schema::create('attendance_access', function($t){
            $t->increments('access_id');
            $t->integer('class_group_id')->unsigned();
            $t->foreign('class_group_id')->references('class_group_id')->on('classification_group');
            $t->integer('attendance_group_id')->unsigned();
            $t->foreign('attendance_group_id')->references('attendance_group_id')->on('attendance_group');
        });

		//Attendance Station
        Schema::create('attendance_station', function($t){
            $t->increments('attendance_station_id');
            $t->string('ip',45);
            $t->string('name',45);
            $t->string('description',100);
            $t->boolean('enable_status')->default(true);
            $t->integer('attendance_group_id')->unsigned();
            $t->foreign('attendance_group_id')->references('attendance_group_id')->on('attendance_group');
        });

        //Attendance Time Logs
        Schema::create('attendance_time_logs', function($t){
            $t->integer('attendance_station_id')->unsigned();
            $t->foreign('attendance_station_id')->references('attendance_station_id')->on('attendance_station');
            $t->string('id_number',45);
            $t->foreign('id_number')->references('id_number')->on('members');
            $t->dateTime('date_time');
            $t->string('status',45);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('attendance_time_logs');
		Schema::drop('attendance_access');
		Schema::drop('attendance_station');
		Schema::drop('attendance_group');
	}

}
