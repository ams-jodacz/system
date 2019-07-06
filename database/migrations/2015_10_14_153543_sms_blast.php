<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SmsBlast extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//SMS DIRECT MESSAGE LOGS
        Schema::create('sms_direct_message_logs', function($t){
            $t->increments('direct_message_id');
            $t->integer('class_id')->unsigned()->nullable();
            $t->foreign('class_id')->references('class_id')->on('classification');
            $t->integer('class_group_id')->unsigned()->nullable();
            $t->foreign('class_group_id')->references('class_group_id')->on('classification_group');
            $t->integer('member_id')->unsigned()->nullable();
            $t->foreign('member_id')->references('member_id')->on('members');
            $t->text('message');
            $t->dateTime('send_date_time');
        });

		//SMS BLAST
        Schema::create('sms_blast', function($t){
            $t->increments('sms_blast_id');
            $t->integer('class_id')->unsigned()->nullable();
            $t->foreign('class_id')->references('class_id')->on('classification');
            $t->integer('class_group_id')->unsigned()->nullable();
            $t->foreign('class_group_id')->references('class_group_id')->on('classification_group');
            $t->integer('member_id')->unsigned()->nullable();
            $t->foreign('member_id')->references('member_id')->on('members');
            $t->boolean('occurance')->default(false);
            $t->text('message');
            $t->dateTime('send_date_time')->nullable();
        });

		//SMS BLAST OCCURANCE
        Schema::create('sms_blast_occurance', function($t){
            $t->increments('sms_blast_occurance_id');
            $t->integer('sms_blast_id')->unsigned();
            $t->foreign('sms_blast_id')->references('sms_blast_id')->on('sms_blast');
            $t->string('minute',2);
            $t->string('hour',2);
            $t->string('day_of_month',2);
            $t->string('month',2);
            $t->string('day_of_week',2);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sms_blast_occurance');
		Schema::drop('sms_blast');
		Schema::drop('sms_direct_message_logs');
	}

}
