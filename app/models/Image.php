<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Image extends Eloquent {

    public function user(){
        return $this->belongsTo('User');
    }

    public function recipe(){
        return $this->belongsTo('Recipe');
    }
}
