<?php

/**
 * View Controller
 *
 * Contains view definition for all app view
 *
 * @copyright  2018 Toque Chef
 */
class ViewController extends BaseController
{

    /**
     *
     * Add Recipe view
     * Auth Required
     *
     * @return      view
     *
     */
    public function showAddRecipe()
    {
        $data['hasMainPage'] = true;
        $data['ingredients'] = Ingredient::orderBy('name')->get();
        $data['categories'] = Config::get('params.categories');

        return View::make('recipes.add', $data);
    }

    /**
     *
     * Add recipe step view
     * Auth required, and user()->id must match with recipe->owner
     *
     * @param    integer $id Recipe id
     * @return      view
     *
     */
    public function showAddStep($id)
    {
        $data['hasMainPage'] = true;
        $data['recipe'] = Recipe::find($id);
        if (Auth::user()->id != $data['recipe']->owner_id) {
            return Redirect::route('recipes.details', $data['recipe']->id);
        }
        $data['add'] = true;

        return View::make('recipes.step', $data);
    }

    /**
     *
     * Edit recipe view
     * Auth required, and user()->id must match with recipe->owner
     *
     * @param    integer $id Recipe id
     * @return      view
     *
     */
    public function showEditRecipe($id)
    {
        $data['hasMainPage'] = true;
        $data['recipe'] = Recipe::find($id);
        if (Auth::user()->id != $data['recipe']->owner_id) {
            return Redirect::route('recipes.details', $data['recipe']->id);
        }
        $ingredients = Recipe::find($id)->ingredients('name')->get();
        $data['recipeIngredients'] = $ingredients->toArray();
        $data['ingredients'] = Ingredient::all();
        $data['categories'] = Config::get('params.categories');

        return View::make('recipes.edit', $data);
    }

    /**
     *
     * Edit recipe step view
     * Auth required, and user()->id must match with recipe->owner
     *
     * @param    integer $id Step id
     * @return      view
     *
     */
    public function showEditStep($id)
    {
        $data['hasMainPage'] = true;
        $data['step'] = Step::find($id);
        $data['recipe'] = Recipe::find($data['step']->recipe_id);
        if (Auth::user()->id != $data['recipe']->owner_id) {
            return Redirect::route('recipes.details', $data['recipe']->id);
        }
        $data['add'] = false;

        return View::make('recipes.step', $data);
    }

    /**
     *
     * Favorites Recipes Collection View
     * Auth Required
     *
     * @return      view
     *
     */
    public function showFavorites()
    {
        $data['hasMainPage'] = true;
        $data['recipes'] = Profile::find(Auth::user()->id)->favorites()->with('recipe')->get();

        return View::make('recipes.favorites', $data);
    }

    /**
     *
     * Home view, Landing page
     *
     * @return      view
     *
     */
    public function showHome()
    {
        $data['recipes'] = count(Recipe::all());
        $data['ingredients'] = count(Ingredient::all());
        $data['users'] = count(User::all());
        $data['comments'] = count(Comment::all());

        return View::make('home', $data);
    }

    /**
     *
     * View of 10 last recipes
     *
     * @return      view
     *
     */
    public function showLastRecipes()
    {
        $data['hasMainPage'] = true;
        $data['recipes'] = Recipe::with(['owner', 'images'])->orderBy('id', 'desc')->limit(10)->get();
        $data['title'] = '10 Dernières recettes';
        return View::make('recipes.list', $data);
    }

    /**
     *
     * Login view
     *
     * @return      view
     *
     */
    public function showLogin()
    {
        if(Auth::user()){
            return Redirect::route('home');
        }
        return View::make('login');
    }

    /**
     *
     * Manage quantity view
     * Auth required, and user()->id must match with recipe->owner
     *
     * @param    integer $id Recipe id
     * @return      view
     *
     */
    public function showManageQuantity($id)
    {
        $data['hasMainPage'] = true;
        $data['recipe'] = Recipe::find($id);
        if (Auth::user()->id != $data['recipe']->owner_id) {
            return Redirect::route('recipes.details', $data['recipe']->id);
        }

        return View::make('recipes.manage', $data);
    }

    /**
     *
     * Personals Recipes view
     * Auth Required
     *
     * @return      view
     *
     */
    public function showMyRecipes()
    {
        $data['hasMainPage'] = true;
        $data['recipes'] = Profile::find(Auth::user()->id)->recipes;

        return View::make('recipes.my', $data);
    }

    /**
     *
     * Profile view
     *
     * @param    integer $id Profile id
     * @return      view
     *
     */
    public function showProfile($id)
    {
        $data['hasMainPage'] = false;
        $data['profile'] = Profile::find($id);

        return View::make('profile', $data);
    }

    /**
     *
     * Show details of recipe view
     *
     * @param    integer $id The recipe id
     * @return      view
     *
     */
    public function showRecipeDetails($id)
    {
        if(!Recipe::find($id)){
            return View::make('errors.404');
        }
        $data['hasMainPage'] = true;
        $data['recipe'] = Recipe::find($id);
        $data['ingredients'] = Recipe::find($id)->ingredients;
        $data['steps'] = null;
        if (Auth::user()) {
            $like = Like::where('recipe_id', $id)->where('profile_id', Auth::user()->id)->first();
            $favorite = Favorite::where('recipe_id', $id)->where('profile_id', Auth::user()->id)->first();
            if ($like) {
                $data['like'] = true;
            } else {
                $data['like'] = false;
            }
            if ($favorite) {
                $data['favorite'] = true;
            } else {
                $data['favorite'] = false;
            }
        } else {
            $data['like'] = false;
            $data['favorite'] = false;
        }

        return View::make('recipes.details', $data);
    }

    /**
     *
     * Register view
     *
     * @return      view
     *
     */
    public function showRegister()
    {
        if(Auth::user()){
            return Redirect::route('home');
        }
        return View::make('register');
    }

    /**
     *
     * View of 10 most liked recipes
     *
     * @return      view
     *
     */
    public function showTopRecipes()
    {
        $data['hasMainPage'] = true;
        $data['recipes'] = Recipe::with(['owner', 'images'])->orderBy('likes', 'desc')->limit(10)->get();
        $data['title'] = '10 Meilleures recettes';

        return View::make('recipes.list', $data);
    }
}