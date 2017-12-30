<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class IngredientRecipe extends Eloquent  {

    protected $table = 'ingredient_recipe';

    var $fillable = ['ingredient_id','recipe_id','quantity','unit'];

    public $timestamps = false;


    public function ingredient(){
        return $this->belongsTo('Ingredient');
    }

    public function recipe(){
        return $this->belongsTo('Recipe');
    }
}
