<?php

class IngredientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('ingredients')->delete();

        $ingredients = file(asset('ingredients.txt'));
        $data = [];
        foreach ($ingredients as $ingredient) {
            $data[]['name'] = $ingredient;
        }

        DB::table('ingredients')->insert($data);
    }
}