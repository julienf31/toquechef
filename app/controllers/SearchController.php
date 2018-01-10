<?php

class SearchController extends BaseController
{

    public function search()
    {
        $params = Input::get('search');
        $data['recipes'] = $this->launchRecipesSearch($params);
        $data['ingredients'] = $this->launchIngredientsSearch($params);
        $data['categories'] = $this->launchCategoriesSearch($params);

        $data['keyword'] = $params;

        $data['count'] = count($data['recipes']) + count($data['ingredients']) + count($data['categories']);

        return View::make('search.results', $data);

    }

    public function launchRecipesSearch($params)
    {
        $results = Recipe::where('name', 'like', '%' . $params . '%')
            ->orWhere('description', 'like', '%' . $params . '%')->get();

        return $results;
    }

    public function launchIngredientsSearch($params)
    {
        $results = Recipe::whereHas('ingredients', function ($query) use ($params) {
            $query->where('name', 'like', '%' . $params . '%');
        })->get();

        return $results;
    }

    public function launchCategoriesSearch($params)
    {
        $results = Recipe::where('category', 'like', '%' . $params . '%')->get();

        return $results;
    }

    public function searchIngredients($id)
    {
        $ingredient = Ingredient::find($id);
        $data['recipes'] = $this->launchIngredientsSearch($ingredient->name);
        $data['keyword'] = $ingredient->name;

        return View::make('search.ingredients', $data);
    }

    public function searchCategory($name)
    {
        $data['recipes'] = $this->launchCategoriesSearch($name);
        $data['keyword'] = $name;

        return View::make('search.categories', $data);
    }
}
