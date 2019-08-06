<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SmsConfiguration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//SMS SERVER
        Schema::create('sms_server', function($t){
            $t->increments('sms_server_id');
            $t->string('server_name',45);
            $t->string('ip',45);
            $t->string('username',45);
            $t->string('password',45);
        });

        //Attendance Access
        Schema::create('sms_prefix_group', function($t){
            $t->increments('sms_prefix_group_id');
            $t->string('group_name',45);
        });

		//Attendance Station
        Schema::create('sms_prefix_list', function($t){
            $t->increments('sms_prefix_id');
            $t->integer('sms_prefix_group_id')->unsigned();
            $t->foreign('sms_prefix_group_id')->references('sms_prefix_group_id')->on('sms_prefix_group');
            $t->string('prefix',20);
        });

        //Attendance Time Logs
        Schema::create('sms_access', function($t){
        	$t->increments('sms_access_id');
            $t->integer('sms_server_id')->unsigned();
            $t->foreign('sms_server_id')->references('sms_server_id')->on('sms_server');
            $t->integer('sms_prefix_group_id')->unsigned();
            $t->foreign('sms_prefix_group_id')->references('sms_prefix_group_id')->on('sms_prefix_group');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sms_access');
		Schema::drop('sms_prefix_list');
		Schema::drop('sms_prefix_group');
		Schema::drop('sms_server');
	}

}
