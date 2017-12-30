<?php

class RecipesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('recipes')->delete();
        DB::table('images')->delete();

        $recipes = array(
            array('id' => '1','name' => 'Gateau au chocolat','description' => 'Un bon gâteau au chocolat, moelleux à l\'intérieur et croustillant à l\'extérieur !','owner_id' => '1','category' => 'Dessert','created_at' => '2017-12-23 15:55:47','updated_at' => '2017-12-23 15:55:47')
        );

        $images = array(
            array('id' => '1','recipe_id' => '1','name' => '452801f474c65c2611fdfc47cb979514.jpg','created_at' => '2017-12-23 15:55:47','updated_at' => '2017-12-23 15:55:47')
        );

        DB::table('recipes')->insert($recipes);
        DB::table('images')->insert($images);
    }
}