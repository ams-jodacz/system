<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Acl extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            //Group Table
            Schema::create('tbl_group', function($t) {
                $t->increments('group_id');
                $t->string('group_name', 100);
            });
            
            //Users Table
            Schema::create('tbl_users', function($t) {
                $t->increments('user_id');
                $t->string('username', 50);
                $t->string('password', 64);
                $t->integer('group_id')->unsigned();
                $t->foreign('group_id')->references('group_id')->on('tbl_group');
                $t->enum('status',array('Inactive','Active'))->default('Active');
	            $t->enum('remove_status',array('Inactive','Active'))->default('Inactive');
                $t->dateTime('last_login')->nullable();
            });
            
            //Users Info Table
            Schema::create('tbl_user_info', function($t) {
                $t->increments('user_info_id');
                $t->integer('user_id')->unsigned();
                $t->foreign('user_id')->references('user_id')->on('tbl_users');
                $t->string('first_name', 100)->nullable();
                $t->string('middle_name', 100)->nullable();
                $t->string('last_name', 100)->nullable();
                $t->string('profile_pic', 100)->nullable();
            });
            
            //Module Table
            Schema::create('tbl_module', function($t) {
                $t->increments('module_id');
                $t->string('module_name',45);
            });
            
            //Page Table
            Schema::create('tbl_page', function($t) {
                $t->increments('page_id');
                $t->integer('module_id')->unsigned();
                $t->foreign('module_id')->references('module_id')->on('tbl_module');
                $t->string('page_name', 45);
                $t->string('page_url', 45);
                $t->integer('page_max_action');
            });
            
            //Permission Table
            Schema::create('tbl_permission', function($t) {
                $t->integer('group_id')->unsigned();
                $t->foreign('group_id')->references('group_id')->on('tbl_group');
                $t->integer('module_id')->unsigned();
                $t->foreign('module_id')->references('module_id')->on('tbl_module');
                $t->integer('page_id')->unsigned();
                $t->foreign('page_id')->references('page_id')->on('tbl_page');
                $t->integer('action_value');
            });
            
            //Action Table
            Schema::create('tbl_action', function($t) {
                $t->increments('action_id');
                $t->string('action_name',45);
                $t->integer('action_value');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            Schema::drop('tbl_action');
            Schema::drop('tbl_permission');
            Schema::drop('tbl_page');
            Schema::drop('tbl_module');
            Schema::drop('tbl_user_info');
            Schema::drop('tbl_users');
            Schema::drop('tbl_group');
	}

}
