<?php

class IngredientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ingredients')->delete();
        $ingredients = array(
            array('name' => 'poulet'),
            array('name' => 'curry'),
            array('name' => 'sel'),
            array('name' => 'poivre'),
            array('name' => 'lait de coco'),
            array('name' => 'poivrons'),
            array('name' => 'oignons'),
            array('name' => 'ail'),
        );

        $ingredients = file(asset('ingredients.txt'));
        $data = [];
        foreach ($ingredients as $ingredient) {
            $data[]['name'] = $ingredient;
        }

        DB::table('ingredients')->insert($data);
    }
}