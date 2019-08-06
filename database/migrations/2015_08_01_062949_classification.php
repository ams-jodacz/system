<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Classification extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Classification
        Schema::create('classification', function($t){
            $t->increments('class_id');
            $t->string('classification_name', 45);
        });

        //Classification Group
        Schema::create('classification_group', function($t) {
            $t->increments('class_group_id');
            $t->integer('class_id')->unsigned();
            $t->foreign('class_id')->references('class_id')->on('classification');
            $t->string('group_name', 45);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('classification_group');
		Schema::drop('classification');
	}

}
