<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Like extends Eloquent  {

    var $fillable = ['id','recipe_id','profile_id'];

    public function recipe(){
        return $this->belongsTo('Recipe');
    }
}
