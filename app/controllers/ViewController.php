<?php

class ViewController extends BaseController
{

    //Home view
    public function showHome()
    {
        $data['recipes'] = count(Recipe::all());
        $data['ingredients'] = count(Ingredient::all());
        $data['users'] = count(User::all());
        $data['comments'] = count(Comment::all());

        return View::make('home', $data);
    }

    //Login view
    public function showLogin()
    {
        return View::make('login');
    }

    //Register view
    public function showRegister()
    {
        return View::make('register');
    }

    //Profile view
    public function showProfile($id)
    {
        $data['hasMainPage'] = false;
        $data['profile'] = Profile::find($id);

        return View::make('profile', $data);
    }

    //Add recipes view
    public function showAddRecipe()
    {
        $data['hasMainPage'] = true;
        $data['ingredients'] = Ingredient::orderBy('name')->get();
        $data['categories'] = Config::get('params.categories');

        return View::make('recipes.add', $data);
    }

    //My recipes view
    public function showMyRecipes()
    {
        $data['hasMainPage'] = true;
        $data['recipes'] = Profile::find(Auth::user()->id)->recipes;

        return View::make('recipes.my', $data);
    }

    //Favorites recipes view
    public function showFavorites()
    {
        $data['hasMainPage'] = true;
        $data['recipes'] = Profile::find(Auth::user()->id)->favorites()->with('recipe')->get();

        return View::make('recipes.favorites', $data);
    }

    //Last recipes view
    public function showLastRecipes()
    {
        $data['hasMainPage'] = true;
        $data['recipes'] = Recipe::with(['owner', 'images'])->orderBy('id', 'desc')->limit(10)->get();
        $data['title'] = '10 Dernières recettes';
        return View::make('recipes.list', $data);
    }

    //Top recipes view
    public function showTopRecipes()
    {
        $data['hasMainPage'] = true;
        $data['recipes'] = Recipe::with(['owner', 'images'])->orderBy('likes', 'desc')->limit(10)->get();
        $data['title'] = '10 Meilleures recettes';

        return View::make('recipes.list', $data);
    }

    //Details recipes view
    public function showRecipeDetails($id)
    {
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

    //Edit recipes view
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

    //Manage recipes quantity view
    public function showManageQuantity($id)
    {
        $data['hasMainPage'] = true;
        $data['recipe'] = Recipe::find($id);
        if (Auth::user()->id != $data['recipe']->owner_id) {
            return Redirect::route('recipes.details', $data['recipe']->id);
        }

        return View::make('recipes.manage', $data);
    }

    //Add recipes step view
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

    //Add recipes step view
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
}
