<?php

class SearchController extends BaseController
{

    public function search()
    {
        $params = Input::get('search');
        $multiple = explode(' ', $params);

        if (sizeof($multiple) > 1) {
            $data['ingredients'] = $this->launchMultipleIngredientsSearch($multiple);
        }else{
            $data['ingredients'] = $this->launchIngredientsSearch($params);
        }
        $data['recipes'] = $this->launchRecipesSearch($params);
        $data['categories'] = $this->launchCategoriesSearch($params);
        $data['keyword'] = $params;
        $data['count'] = count($data['recipes']) + count($data['ingredients']) + count($data['categories']);

        $data['similarIngredients'] = Ingredient::where('name', 'like', '%'.$params.'%')->get();

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

    public function launchMultipleIngredientsSearch($params)
    {
        $query = Recipe::query();
        foreach ($params as $param) {
            $query = $query->whereHas('ingredients', function ($query) use ($param) {
                $query->where('name','like','%'.$param.'%');
            });
        }
        $results = $query->get();

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
