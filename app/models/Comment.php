<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Comment extends Eloquent  {

    var $fillable = ['id','recipe_id','profile_id','comment'];

    public function recipe(){
        return $this->belongsTo('Recipe');
    }

    public function profile(){
        return $this->belongsTo('Profile');
    }
}
