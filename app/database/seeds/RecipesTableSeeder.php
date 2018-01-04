<?php

class RecipesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('recipes')->delete();
        DB::table('images')->delete();
        DB::table('likes')->delete();
        DB::table('ingredient_recipe')->delete();
        DB::table('steps')->delete();
        DB::table('comments')->delete();

        $recipes = array(
            array('id' => '1','name' => 'Gateau au chocolat','description' => 'Un bon gâteau au chocolat, moelleux à l\'intérieur et croustillant à l\'extérieur ! ( Si on se chie pas la cuisson (c\'est pas facile la cuisson))','owner_id' => '1','persons' => '6','difficulty' => '1','price' => '10','category' => 'Dessert','likes' => '1','created_at' => '2017-12-19 15:55:47','updated_at' => '2018-01-04 21:49:48')
        );

        $images = array(
            array('id' => '1','recipe_id' => '1','name' => '452801f474c65c2611fdfc47cb979514.jpg','created_at' => '2017-12-19 15:55:47','updated_at' => '2017-12-23 15:55:47')
        );

        $likes = array(
            array('id' => '1','recipe_id' => '1','profile_id' => '1','created_at' => '2018-01-04 21:49:27','updated_at' => '2018-01-04 21:49:27')
        );

        $ingredient_recipe = array(
            array('id' => '1','recipe_id' => '1','ingredient_id' => '37','quantity' => '100.00','unit' => 'g'),
            array('id' => '2','recipe_id' => '1','ingredient_id' => '111','quantity' => '200.00','unit' => 'g'),
            array('id' => '3','recipe_id' => '1','ingredient_id' => '207','quantity' => '150.00','unit' => 'g'),
            array('id' => '4','recipe_id' => '1','ingredient_id' => '340','quantity' => '1.00','unit' => 'unité'),
            array('id' => '5','recipe_id' => '1','ingredient_id' => '398','quantity' => '4.00','unit' => 'unité'),
            array('id' => '6','recipe_id' => '1','ingredient_id' => '551','quantity' => '200.00','unit' => 'g'),
            array('id' => '7','recipe_id' => '1','ingredient_id' => '580','quantity' => '2.00','unit' => 'cuil. à soupe')
        );

        $steps = array(
            array('id' => '1','recipe_id' => '1','order' => 'Faire fondre le chocolat et le beurre '),
            array('id' => '2','recipe_id' => '1','order' => 'Dans un autre récipient, mélanger les oeufs, la farine le sucre et la levure '),
            array('id' => '3','recipe_id' => '1','order' => 'Bien mélanger jusqu\'à ce qu\'il n\'y ai plus de grumeaux, c\'est pas bon les grumeaux  '),
            array('id' => '4','recipe_id' => '1','order' => 'Mélanger le chocolat au reste'),
            array('id' => '5','recipe_id' => '1','order' => ' Verser le mélange dans un moule au préalablement beurré à l\'aide de beurre'),
            array('id' => '6','recipe_id' => '1','order' => ' Faire cuire (au four) préchauffé à 180 °C pendant environ 10 à 50 minutes en fonction de la cuisson désirée'),
            array('id' => '7','recipe_id' => '1','order' => 'Décorer de vermicelles une fois cuit'),
            array('id' => '8','recipe_id' => '1','order' => 'Manger')
        );

        $comments = array(
            array('id' => '1','recipe_id' => '1','profile_id' => '1','comment' => 'J\'adore ce gâteau, c\'est trop bon le chocolat. Je like ;)','created_at' => '2018-01-04 21:49:20','updated_at' => '2018-01-04 21:49:20')
        );

        DB::table('recipes')->insert($recipes);
        DB::table('images')->insert($images);
        DB::table('likes')->insert($likes);
        DB::table('ingredient_recipe')->insert($ingredient_recipe);
        DB::table('steps')->insert($steps);
        DB::table('comments')->insert($comments);
    }
}