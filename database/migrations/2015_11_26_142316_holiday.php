<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Holiday extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//SMS Late Absent
        Schema::create('holiday', function($t){
            $t->increments('holiday_id');
            $t->string('name',100);
            $t->string('description',100);
            $t->date('date');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('holiday');
	}

}
