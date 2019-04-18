<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Guest extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Guest Tag Group
        Schema::create('guest_tag_group', function($t){
            $t->increments('guest_group_id');
            $t->string('group_name',45);
        });

		//Guest Tag Access
        Schema::create('guest_station_access', function($t){
            $t->increments('access_id');
            $t->integer('guest_group_id')->unsigned();
            $t->foreign('guest_group_id')->references('guest_group_id')->on('guest_tag_group');
            $t->integer('station_group_id')->unsigned();
            $t->foreign('station_group_id')->references('station_group_id')->on('station_group');
        });

		//Guest Tag
        Schema::create('guest_tags', function($t){
        	$t->increments('tag_id');
            $t->integer('guest_group_id')->unsigned();
            $t->foreign('guest_group_id')->references('guest_group_id')->on('guest_tag_group');
            $t->string('id_number',45)->unique();
            $t->string('tag',45)->nullable()->unique();
            $t->string('tag_name',45);
        });

		//Guest Logs
        Schema::create('guest_logs', function($t){
        	$t->increments('id');
            $t->integer('tag_id')->unsigned();
            $t->foreign('tag_id')->references('tag_id')->on('guest_tags');
            $t->text('users');
            $t->string('contact_number',45);
            $t->text('reason');
            $t->text('items');
            $t->dateTime('borrow_date_time');
            $t->dateTime('return_date_time')->nullable()->default(NULL);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('guest_logs');
		Schema::drop('guest_tags');
		Schema::drop('guest_station_access');
		Schema::drop('guest_tag_group');
	}

}
