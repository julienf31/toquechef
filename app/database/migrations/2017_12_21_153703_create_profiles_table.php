<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('profiles', function(Blueprint $table)
    {
        $table->increments('id')->unsigned();
        $table->string('firstname', 30);
        $table->string('lastname', 30);
        $table->string('picture');
        $table->string('location');
        $table->date('birthdate');
        $table->timestamps();

        $table->foreign('id')->references('id')->on('users');

    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('profiles');
	}

}
