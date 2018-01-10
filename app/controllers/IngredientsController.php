<?php

/**
 * Ingredients Controller
 *
 * Method for ingredients CRUD management
 *
 * @copyright  2018 Toque Chef
 */
class IngredientsController extends BaseController
{

    /**
     *
     * Add Ingredient
     * Auth Required
     *
     * @return      Redirect
     *
     */
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
