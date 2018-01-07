<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Recipe extends Eloquent  {

    var $fillable = ['id','name','description','category','owner_id','difficulty','price','persons'];

    public function owner(){
        return $this->belongsTo('Profile', 'owner_id');
    }

    public function images(){
        return $this->hasMany('Image');
    }

    public function ingredients(){
        return $this->belongsToMany('Ingredient')->withPivot('quantity','unit');
    }

    public function steps(){
        return $this->hasMany('Step');
    }

    public function likes(){
        return $this->hasMany('Like');
    }

    public function comments(){
        return $this->hasMany('Comment');
    }

    public function favorites(){
        return $this->hasMany('Favorite');
    }

}
