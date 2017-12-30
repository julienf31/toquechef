<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Profile extends Eloquent {

    public function user(){
        return $this->hasOne('User', 'id');
    }

    public function recipes(){
        return $this->hasMany('Recipe', 'owner_id');
    }
}
