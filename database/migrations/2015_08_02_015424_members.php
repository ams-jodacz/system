<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Members extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Member
        Schema::create('members', function($t){
            $t->increments('member_id');
            $t->string('id_number',45)->unique();
            $t->boolean('active_status')->default(true);
            $t->integer('class_group_id')->unsigned();
            $t->foreign('class_group_id')->references('class_group_id')->on('classification_group');
        });

        //Members Information
        Schema::create('member_information', function($t) {
            $t->increments('member_info_id');
            $t->integer('member_id')->unsigned();
            $t->foreign('member_id')->references('member_id')->on('members');
            $t->string('first_name', 45);
            $t->string('middle_name', 45);
            $t->string('last_name', 45);
            $t->string('contact_number', 45);
            $t->string('email', 45);
            $t->string('image', 45);
        });

        //Recipients
        Schema::create('recipients', function($t) {
            $t->increments('recipient_id');
            $t->integer('member_id')->unsigned();
            $t->foreign('member_id')->references('member_id')->on('members');
            $t->string('first_name', 45);
            $t->string('middle_name', 45);
            $t->string('last_name', 45);
            $t->string('contact_number', 45);
            $t->string('email', 45);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('recipients');
		Schema::drop('member_information');
		Schema::drop('members');
	}

}
