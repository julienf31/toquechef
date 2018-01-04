<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('recipes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('description', 300);
            $table->integer('owner_id')->unsigned();
            $table->integer('persons')->default(4);
            $table->integer('difficulty');
            $table->integer('price');
            $table->enum('category',Config::get('params.categories'));
            $table->integer('likes');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('profiles');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('recipes');
	}

}
