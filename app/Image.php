<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //TABLA IMAGES
    protected $table = "images";

    //Relacion Uno a Muchos 
    public function comments(){
        return $this->hasMany("App\Comment");
    }

    //Relacion UNO A MUCHOS

    public function likes(){
        return $this->hasMany("App\Like");
    }

    //RELACION MUCHOS A UNO

public function user(){
    return $this->belongsTo("App\User", "user_id");
    }
}