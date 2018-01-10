<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', array('as' => 'home', 'uses' => 'ViewController@showHome'));

Route::get('/login', array('as' => 'login', 'uses' => 'ViewController@showLogin'));
Route::post('/login', array('uses' => 'LoginController@login'));

Route::get('/register', array('as' => 'register', 'uses' => 'ViewController@showRegister'));
Route::post('/register', array('uses' => 'LoginController@register'));

Route::get('/profile/{id}', array('as' => 'profile', 'uses' => 'ViewController@showProfile'));

Route::get('/top', array('as' => 'recipes.top', 'uses' => 'ViewController@showTopRecipes'));

Route::get('/recipe/{id}/print', array('as' => 'recipes.print', 'uses' => 'RecipesController@generatePDF'));

Route::get('/last', array('as' => 'recipes.last', 'uses' => 'ViewController@showLastRecipes'));

Route::get('/recipe/random', array('as' => 'recipes.random', 'uses' => 'RecipesController@randomRecipe'));

Route::get('/recipe/{id}', array('as' => 'recipes.details', 'uses' => 'ViewController@showRecipeDetails'));

Route::post('/search', array('as' => 'search', 'uses' => 'SearchController@search'));

Route::get('/search/ingredients/{id}', array('as' => 'search.ingredients', 'uses' => 'SearchController@searchIngredients'));

Route::get('/search/category/{name}', array('as' => 'search.category', 'uses' => 'SearchController@searchCategory'));

Route::group(array('before' => 'auth'), function () {
    Route::post('/profile/{id}/edit', array('as' => 'profile.edit', 'uses' => 'ProfileController@editProfile'));
    Route::post('/profile/{id}/credentials', array('as' => 'profile.edit.credentials', 'uses' => 'ProfileController@editCredentials'));
    Route::post('/profile/{id}/infos', array('as' => 'profile.edit.infos', 'uses' => 'ProfileController@editInfos'));

    Route::any('/logout', array('as' => 'logout', 'uses' => 'LoginController@logout'));

    Route::get('/my', array('as' => 'recipes.my', 'uses' => 'ViewController@showMyRecipes'));

    Route::get('/favorites', array('as' => 'recipes.favorites', 'uses' => 'ViewController@showFavorites'));

    Route::get('/add', array('as' => 'recipes.add', 'uses' => 'ViewController@showAddRecipe'));
    Route::post('/add', array('as' => 'recipes.add', 'uses' => 'RecipesController@addRecipes'));

    Route::get('/ingredients/add', array('as' => 'ingredients.add', 'uses' => 'ViewController@showAddIngredient'));
    Route::post('/ingredients/add', array('as' => 'ingredients.add', 'uses' => 'IngredientsController@addIngredient'));

    Route::post('/recipe/delete/{id}', array('as' => 'recipes.delete', 'uses' => 'RecipesController@deleteRecipe'));

    Route::get('/recipe/edit/{id}', array('as' => 'recipes.edit', 'uses' => 'ViewController@showEditRecipe'));
    Route::post('/recipe/edit/{id}', array('as' => 'recipes.edit', 'uses' => 'RecipesController@editRecipe'));

    Route::get('/recipe/{id}/ingredients', array('as' => 'recipes.ingredients.manage', 'uses' => 'ViewController@showManageQuantity'));
    Route::post('/recipe/{id}/ingredients', array('as' => 'recipes.ingredients.manage', 'uses' => 'RecipesController@manageQuantity'));

    Route::get('/recipe/{id}/step/add', array('as' => 'recipes.step.add', 'uses' => 'ViewController@showAddStep'));
    Route::post('/recipe/{id}/step/add', array('as' => 'recipes.step.add', 'uses' => 'RecipesController@addStep'));

    Route::get('/step/{id}/delete', array('as' => 'recipes.step.delete', 'uses' => 'RecipesController@deleteStep'));

    Route::get('/step/{id}/edit', array('as' => 'recipes.step.edit', 'uses' => 'ViewController@showEditStep'));
    Route::post('/step/{id}/edit', array('as' => 'recipes.step.edit', 'uses' => 'RecipesController@editStep'));

    Route::get('/recipe/{id}/like', array('as' => 'recipes.like', 'uses' => 'RecipesController@likeRecipe'));
    Route::get('/recipe/{id}/favorite', array('as' => 'recipes.favorite.add', 'uses' => 'RecipesController@favoriteRecipe'));

    Route::post('/recipe/{id}/comment', array('as' => 'comments.add', 'uses' => 'RecipesController@addComment'));
    Route::get('/comment/{id}/delete', array('as' => 'comments.delete', 'uses' => 'RecipesController@deleteComment'));

});
