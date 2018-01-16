<?php

/**
 * Recipe Controller
 *
 * Method for recipes management
 *
 * @copyright  2018 Toque Chef
 */
class RecipesController extends BaseController
{

    /**
     *
     * Add comment to recipe
     * Auth Required
     *
     * @param       integer $id Recipe id
     * @return      Redirect
     *
     */
    public function addComment($id)
    {
        $recipe = Recipe::find($id);

        $comment = new Comment();
        $comment->recipe_id = $recipe->id;
        $comment->profile_id = Auth::user()->id;
        $comment->comment = Input::get('comment');
        $comment->save();

        return Redirect::route('recipes.details', $recipe->id);
    }

    /**
     *
     * Add Recipe Image
     * Auth Required, user()->id must match with recipe->owner
     *
     * @return      Redirect
     *
     */
    public function addImage($id)
    {
        $recipe = Recipe::find($id);
        if (Auth::user()->id != $recipe->owner_id) {
            Session::flash('danger-notif', "Accés interdit");
            return Redirect::route('recipes.details', $recipe->id);
        }
        $filesRules = array('img' => 'image');

        $file = Input::file('img');

        if ($file->isValid()) {
            $validator = Validator::make(array('img' => $file), $filesRules);

            if ($validator->fails()) {

            } else {
                $fileName = md5($file->getClientOriginalName());
                $fileExt = $file->getClientOriginalExtension();
                $file->move('uploads/recipes/' . $id, $fileName . '.' . $fileExt);

                $image = new Image();
                $image->name = $fileName . '.' . $fileExt;
                $image->recipe_id = $id;
                $image->save();
            }
            Session::flash('success-notif', "Image ajoutée");
            return Redirect::route('recipes.edit', $image->recipe_id);
        }
        
        Session::flash('danger-notif', "Image non ajoutée");
        return Redirect::route('recipes.edit', $id);
    }

    /**
     *
     * Add Recipe
     * Auth Required
     *
     * @return      Redirect
     *
     */
    public function addRecipes()
    {
        Input::flashExcept('img');
        $validImg = false;

        $rules = array(
            'name' => 'required|min:3',
            'desc' => 'required|min:20',
            'img' => 'required',
            'ingredients' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Redirect::route('recipes.add')->withErrors($validator)->withInput();
        }

        $filesRules = array('img' => 'image');

        $data = array(
            'name' => Input::get('name'),
            'description' => Input::get('desc'),
            'owner_id' => Auth::user()->id,
            'category' => Input::get('category'),
            'difficulty' => Input::get('difficulty'),
            'persons' => Input::get('persons'),
            'price' => Input::get('price'),
        );

        $files = Input::file('img');

        $recipe = new Recipe();
        $recipeId = $recipe->create($data)->id;

        foreach ($files as $file) {
            if ($file->isValid()) {
                $validImg = true;
                $validator = Validator::make(array('img' => $file), $filesRules);

                if ($validator->fails()) {

                } else {
                    $fileName = md5($file->getClientOriginalName());
                    $fileExt = $file->getClientOriginalExtension();
                    $file->move('uploads/recipes/' . $recipeId, $fileName . '.' . $fileExt);

                    $image = new Image();
                    $image->name = $fileName . '.' . $fileExt;
                    $image->recipe_id = $recipeId;
                    $image->save();
                }
            }
        }
        
        if(!$validImg){
            $recipe = Recipe::find($recipe->id);
            $recipe->delete();
            Session::flash('danger-notif', "Erreur d'image");
            return Redirect::route('recipes.add')->withInput();
        }
        
        $ingredients = Input::get('ingredients');

        foreach ($ingredients as $ingredient) {
            $ing = new IngredientRecipe();
            $ing->ingredient_id = $ingredient;
            $ing->recipe_id = $recipeId;
            $ing->save();
        }
        Session::flash('success-notif', "La recette à bien été créée");
        return Redirect::route('recipes.details', $recipeId);
    }

    /**
     *
     * Add step to recipe
     * Auth Required, user()->id must match with recipe->owner
     *
     * @param       integer $id Recipe id
     * @return      Redirect
     *
     */
    public function addStep($id)
    {
        $recipe = Recipe::find($id);
        if (Auth::user()->id != $recipe->owner_id) {
            Session::flash('danger-notif', "Accés interdit");
            return Redirect::back();
        }
        $step = new Step();
        $step->recipe_id = $recipe->id;
        $step->order = Input::get('order');
        $step->save();

        return Redirect::route('recipes.details', $recipe->id);
    }

    /**
     *
     * Delete comment
     * Auth Required, user()->id must match with comment->owner
     *
     * @param       integer $id Comment id
     * @return      Redirect
     *
     */
    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if (Auth::user()->id != $comment->profile_id) {
            Session::flash('danger-notif', "Accés interdit");
            return Redirect::back();
        }
        $comment->delete();

        Session::flash('success-notif', "Le commentaire à bien été supprimé");
        return Redirect::route('recipes.details', $comment->recipe_id);
    }

    /**
     *
     * Delete Recipe Image
     *  Auth Required, user()->id must match with recipe->owner
     *
     * @return      Redirect
     *
     */
    public function deleteImage($id)
    {
        $image = Image::find($id);
        if (Auth::user()->id != $image->recipe->owner_id) {
            Session::flash('danger-notif', "Accés interdit");
            return Redirect::route('recipe.details', $image->recipe_id);
        }

        if (Image::where('recipe_id', $image->recipe_id)->count() > 1) {
            File::delete("uploads/recipes/$image->recipe_id/$image->name");
            $image->delete();
            Session::flash('success-notif', "L'image à bien été supprimée");
        } else {
            Session::flash('danger-notif', "Vous ne pouvez pas supprimé la derniére image de la recette");
        }
        return Redirect::route('recipes.edit', $image->recipe_id);
    }

    /**
     *
     * Delete Recipe
     * Auth Required, user()->id must match with recipe->owner
     *
     * @param       integer $id Recipe id
     * @return      Redirect
     *
     */
    public function deleteRecipe($id)
    {
        $recipe = Recipe::find($id);
        if (Auth::user()->id != $recipe->owner_id) {
            Session::flash('danger-notif', "Accés interdit");
            return Redirect::back();
        }
        $recipe->delete();

        Session::flash('danger-notif', "La recette à bien été supprimée");
        return Redirect::route('recipes.my');
    }

    /**
     *
     * Delete step
     * Auth Required, user()->id must match with recipe->owner
     *
     * @param       integer $step_id Step id
     * @return      Redirect
     *
     */
    public function deleteStep($step_id)
    {
        $step = Step::find($step_id);
        if (Auth::user()->id != $step->recipe->owner_id) {
            return Redirect::back();
        }
        $recipe = $step->recipe_id;
        $step->delete();

        return Redirect::route('recipes.details', $recipe);
    }

    /**
     *
     * Edit Recipe
     * Auth Required, user()->id must match with recipe->owner
     *
     * @param       integer $id Recipe id
     * @return      Redirect
     *
     */
    public function editRecipe($id)
    {
        Input::flashExcept('img');

        $rules = array(
            'name' => 'required|min:3',
            'desc' => 'required|min:20',
            'ingredients' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            Session::flash('danger-notif', "Erreur de saisie des champs");
            return Redirect::route('recipes.edit', $id)->withErrors($validator)->withInput();
        }

        $recipe = Recipe::find($id);

        if (Auth::user()->id != $recipe->owner_id) {
            Session::flash('danger-notif', "Accés interdit");
            return Redirect::back();
        }
        $recipe->name = Input::get('name');
        $recipe->description = Input::get('desc');
        $recipe->category = Input::get('category');
        $recipe->difficulty = Input::get('difficulty');
        $recipe->persons = Input::get('persons');
        $recipe->price = Input::get('price');
        $recipe->save();

        $ingredients = Input::get('ingredients');

        foreach ($ingredients as $ingredient) {

            $ing = IngredientRecipe::firstOrCreate(array('ingredient_id' => $ingredient, 'recipe_id' => $id));
        }

        $recipeIngredients = Recipe::find($id);

        foreach ($recipeIngredients->ingredients as $oldIngredient) {
            $find = false;
            foreach ($ingredients as $newIngredient) {
                if ($newIngredient == $oldIngredient->id) {
                    $find = true;
                }
            }
            if (!$find) {
                $removeIng = IngredientRecipe::where('recipe_id', $id)->where('ingredient_id', $oldIngredient->id)->first();
                $removeIng->delete();
            }
        }

        return Redirect::route('recipes.details', $id);
    }

    /**
     *
     * Edit Recipe step
     * Auth Required, user()->id must match with recipe->owner
     *
     * @param       integer $id Step id
     * @return      Redirect
     *
     */
    public function editStep($id)
    {
        $step = Step::find($id);
        if (Auth::user()->id != $step->recipe->owner_id) {
            return Redirect::back();
        }
        $step->order = Input::get('order');
        $step->save();

        return Redirect::route('recipes.details', $step->recipe_id);
    }

    /**
     *
     * Add / Remove Recipe to favorite
     * Auth Required
     *
     * @param       integer $id Recipe id
     * @return      Redirect
     *
     */
    public function favoriteRecipe($id)
    {
        $favorite = Favorite::where('recipe_id', $id)->where('profile_id', Auth::user()->id)->first();
        $recipe = Recipe::find($id);
        if (!$favorite) {
            $favorite = new Favorite();
            $favorite->recipe_id = $recipe->id;
            $favorite->profile_id = Auth::user()->id;
            $favorite->save();
        } else {
            $favorite->delete();
        }

        return Redirect::route('recipes.details', $recipe->id);
    }

    /**
     *
     * Generate PDF with recipe details
     *
     * @param       integer $id Recipe id
     * @return      PDF
     *
     */
    public function generatePDF($id)
    {
        $recipe = Recipe::find($id);
        $data['recipe'] = $recipe;
        $pdf = PDF::loadView('recipes.print', $data);
        return $pdf->download("Toque Chef - $recipe->name");
    }

    /**
     *
     * Like / Unlike Recipe
     * Auth Required
     *
     * @param       integer $id Recipe id
     * @return      Redirect
     *
     */
    public function likeRecipe($id)
    {
        $like = Like::where('recipe_id', $id)->where('profile_id', Auth::user()->id)->first();
        $recipe = Recipe::find($id);
        if (!$like) {
            $like = new Like();
            $like->recipe_id = $recipe->id;
            $like->profile_id = Auth::user()->id;
            $like->save();
            $recipe->likes++;
        } else {
            $like->delete();
            $recipe->likes--;
        }
        $recipe->save();

        return Redirect::route('recipes.details', $recipe->id);
    }

    /**
     *
     * Manage Ingredients Quantity
     * Auth Required, user()->id must match with recipe->owner
     *
     * @param       integer $id Recipe id
     * @return      Redirect
     *
     */
    public function manageQuantity($id)
    {
        $recipe = Recipe::find($id);
        if (Auth::user()->id != $recipe->owner_id) {
            return Redirect::back();
        }
        foreach ($recipe->ingredients as $ingredient) {
            $ing = IngredientRecipe::where('recipe_id', $id)->where('ingredient_id', $ingredient->id)->first();
            $ing->quantity = Input::get($ingredient->id . '-qty');
            $ing->unit = Input::get($ingredient->id . '-unit');
            $ing->save();
        }
        return Redirect::route('recipes.details', $id);
    }

    /**
     *
     * Get Random Recipe ID
     *
     * @return      Redirect
     *
     */
    public function randomRecipe()
    {
        $recipe = Recipe::orderBy(DB::raw('RAND()'))->first();
        return Redirect::route('recipes.details', $recipe->id);
    }

}