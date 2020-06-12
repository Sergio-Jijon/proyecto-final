<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //CONEXION A TABLA COMMENTS
    protected $table = "comments";
//RELACION DE MUCHOS A UNO
    public function user(){
        return $this->belongsTo("App\User","user_id");
    }
//RELACION DE MUCHOS A UNO
    public function image(){
        return $this->belongsTo("App\Image","image_id");
    }
}
