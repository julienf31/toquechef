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
            Session::flash('success-notif', "Ingrédient $ing->name ajouté");
            return Redirect::route('recipes.add');
        }
        Session::flash('danger-notif', "L'ingrédient $ingredient n'as pas été créer, il existe déja un ingrédient similaire");
        return Redirect::route('recipes.add');
    }

}
