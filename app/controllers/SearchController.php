<?php

/**
 * Search Controller
 *
 * Method for search system
 *
 * @copyright  2018 Toque Chef
 */
class SearchController extends BaseController
{

    /**
     *
     * Primary search function, toggle result view
     *
     * @return      view
     *
     */
    public function search()
    {
        $params = Input::get('search');
        $multiple = explode(' ', $params);

        if (sizeof($multiple) > 1) {
            $data['ingredients'] = $this->launchMultipleIngredientsSearch($multiple);
        
            $data['similarIngredients'] = Ingredient::where(function ($query) use($multiple) {
             for ($i = 0; $i < count($multiple); $i++){
                $query->orwhere('name', 'like',  '%' . $multiple[$i] .'%');
             }      
        })->get();
        } else {
            $data['ingredients'] = $this->launchIngredientsSearch($params);
            $data['similarIngredients'] = Ingredient::where('name', 'like', '%' . $params . '%')->get();
        }
        $data['recipes'] = $this->launchRecipesSearch($params);
        $data['categories'] = $this->launchCategoriesSearch($params);
        $data['keyword'] = $params;
        $data['count'] = count($data['recipes']) + count($data['ingredients']) + count($data['categories']);


        return View::make('search.results', $data);
    }

    /**
     *
     * Multiple ingredients search function
     *
     * @param    string[] $params Text to search
     * @return      object
     *
     */
    public function launchMultipleIngredientsSearch($params)
    {
        $query = Recipe::query();
        foreach ($params as $param) {
            $query = $query->whereHas('ingredients', function ($query) use ($param) {
                $query->where('name', 'like', '%' . $param . '%');
            });
        }
        $results = $query->get();

        return $results;
    }

    /**
     *
     * Ingredients search function
     *
     * @param    string $params Text to search
     * @return      object
     *
     */
    public function launchIngredientsSearch($params)
    {
        $results = Recipe::whereHas('ingredients', function ($query) use ($params) {
            $query->where('name', 'like', '%' . $params . '%');
        })->get();

        return $results;
    }

    /**
     *
     * Recipe search function
     *
     * @param    string $params Text to search
     * @return      object
     *
     */
    public function launchRecipesSearch($params)
    {
        $results = Recipe::where('name', 'like', '%' . $params . '%')
            ->orWhere('description', 'like', '%' . $params . '%')->get();

        return $results;
    }

    /**
     *
     * Category search function
     *
     * @param    string $params Text to search
     * @return      object
     *
     */
    public function launchCategoriesSearch($params)
    {
        $results = Recipe::where('category', 'like', '%' . $params . '%')->get();

        return $results;
    }

    /**
     *
     * Category search view
     *
     * @param    string $name Text to search
     * @return      view
     *
     */
    public function searchCategory($name)
    {
        $data['recipes'] = $this->launchCategoriesSearch($name);
        $data['keyword'] = $name;

        return View::make('search.categories', $data);
    }

    /**
     *
     * Ingredient search view
     *
     * @param    integer $id Ingredient id
     * @return      view
     *
     */
    public function searchIngredients($id)
    {
        $ingredient = Ingredient::find($id);
        $data['recipes'] = $this->launchIngredientsSearch($ingredient->name);
        $data['keyword'] = $ingredient->name;

        return View::make('search.ingredients', $data);
    }
}
