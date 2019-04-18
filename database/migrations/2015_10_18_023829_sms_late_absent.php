<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SmsLateAbsent extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//SMS Late Absent
        Schema::create('sms_late_absent', function($t){
            $t->increments('sms_la_id');
            $t->integer('class_id')->unsigned()->nullable();
            $t->foreign('class_id')->references('class_id')->on('classification');
            $t->integer('class_group_id')->unsigned()->nullable();
            $t->foreign('class_group_id')->references('class_group_id')->on('classification_group');
            $t->integer('member_id')->unsigned()->nullable();
            $t->foreign('member_id')->references('member_id')->on('members');
            $t->string('description',100);
            $t->text('late_message');
            $t->text('absent_message');
            $t->time('late_time');
            $t->time('absent_time');
        });

		//SMS DIRECT MESSAGE LOGS
        Schema::create('sms_date_excemption', function($t){
            $t->increments('sms_date_excemption_id');
            $t->integer('class_id')->unsigned()->nullable();
            $t->foreign('class_id')->references('class_id')->on('classification');
            $t->integer('class_group_id')->unsigned()->nullable();
            $t->foreign('class_group_id')->references('class_group_id')->on('classification_group');
            $t->integer('member_id')->unsigned()->nullable();
            $t->foreign('member_id')->references('member_id')->on('members');
            $t->dateTime('start_date_time');
            $t->dateTime('end_date_time');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sms_late_absent');
		Schema::drop('sms_date_excemption');
	}

}
