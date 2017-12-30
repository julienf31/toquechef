<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Ingredient extends Eloquent  {

    public $timestamps = false;

    public function recipes(){
        return $this->belongsToMany('Recipe');
    }
}
