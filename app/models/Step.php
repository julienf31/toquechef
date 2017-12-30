<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Step extends Eloquent  {

    var $fillable = ['id','recipe_id','order'];

    public $timestamps = false;

    public function recipe(){
        return $this->belongsTo('Recipe');
    }
}
