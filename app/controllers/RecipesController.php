<?php

class RecipesController extends BaseController
{

    //Add recipes function
    // Check each files and upload only img
    public function addRecipes()
    {
        Input::flashExcept('img');

        $rules = array(
            'name' => 'required|min:3',
            'desc' => 'required|min:20',
            'img' => 'required',
            'ingredients' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
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

        $ingredients = Input::get('ingredients');

        foreach ($ingredients as $ingredient) {
            $ing = new IngredientRecipe();
            $ing->ingredient_id = $ingredient;
            $ing->recipe_id = $recipeId;
            $ing->save();
        }


        return Redirect::route('home');
    }

    public function deleteRecipe($id)
    {
        $recipe = Recipe::find($id);
        $recipe->delete();

        return Redirect::route('recipes.my');
    }

    public function editRecipe($id)
    {
        Input::flashExcept('img');

        $rules = array(
            'name' => 'required|min:3',
            'desc' => 'required|min:20',
            'ingredients' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails())
        {
            return Redirect::route('recipes.edit', $id)->withErrors($validator)->withInput();
        }

        $recipe = Recipe::find($id);

        if(Auth::user()->id != $recipe->owner_id){
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

    public function manageQuantity($id)
    {
        $recipe = Recipe::find($id);
        if(Auth::user()->id != $recipe->owner_id){
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

    public function addStep($id){
        $recipe = Recipe::find($id);
        if(Auth::user()->id != $recipe->owner_id){
            return Redirect::back();
        }
        $step = new Step();
        $step->recipe_id = $recipe->id;
        $step->order = Input::get('order');
        $step->save();

        return Redirect::route('recipes.details', $recipe->id);
    }

    public function editStep($id){
        $step = Step::find($id);
        if(Auth::user()->id != $step->recipe->owner_id){
            return Redirect::back();
        }
        $step->order = Input::get('order');
        $step->save();

        return Redirect::route('recipes.details', $step->recipe_id);
    }

    public function deleteStep($step_id){
        $step = Step::find($step_id);
        if(Auth::user()->id != $step->recipe->owner_id){
            return Redirect::back();
        }
        $recipe = $step->recipe_id;
        $step->delete();

        return Redirect::route('recipes.details',$recipe);
    }

    public function likeRecipe($id){
        $like = Like::where('recipe_id',$id)->where('profile_id', Auth::user()->id)->first();
        $recipe = Recipe::find($id);
        if(!$like){
            $like = new Like();
            $like->recipe_id = $recipe->id;
            $like->profile_id = Auth::user()->id;
            $like->save();
            $recipe->likes++;
        }else{
            $like->delete();
            $recipe->likes--;
        }
        $recipe->save();

        return Redirect::route('recipes.details', $recipe->id);
    }

    public function addComment($id){
        $recipe = Recipe::find($id);

        $comment = new Comment();
        $comment->recipe_id = $recipe->id;
        $comment->profile_id = Auth::user()->id;
        $comment->comment = Input::get('comment');
        $comment->save();

        return Redirect::route('recipes.details', $recipe->id);
    }

    public function deleteComment($id){
        $comment = Comment::find($id);
        if(Auth::user()->id != $comment->profile_id){
            return Redirect::back();
        }
        $comment->delete();

        return Redirect::route('recipes.details', $comment->recipe_id);
    }

    public function generatePDF($id){
        $recipe = Recipe::find($id);
        $data['recipe'] = $recipe;
        $pdf = PDF::loadView('recipes.print', $data);
        return $pdf->download("Toque Chef - $recipe->name");
    }

}
