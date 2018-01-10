<?php

class IngredientsController extends BaseController
{

    public function addIngredient()
    {
        $ingredient = Input::get('ingredientName');

        if(count(Ingredient::where('name', 'like', $ingredient.'%')->get()) == 0){
            $ing = new Ingredient();
            $ing->name = $ingredient;
            $ing->save();
            return Redirect::route('recipes.add');
        }
        return Redirect::route('recipes.add')->withErrors("<i class=\"fa fa-warning\"></i> &nbsp;L'ingredient n'as pas été créer");
    }

}
