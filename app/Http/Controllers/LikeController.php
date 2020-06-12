<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\like;

class LikeController extends Controller
{
    public function _construct(){
        $this->middleware('auth');
    }

    public function like($image_id){
        //RECOGER DATOS DE USUARIO E IMAGEN

        $user = \Auth::user();

        //CONDICION PARA VER SI EL LIKE YA EXISTE EN LA DB
        $isset_like = Like::where('user_id', $user->id)
                        ->where('image_id', $image_id)
                        ->count();

        if($isset_like == 0) {
            $like = new Like();
            $like->user_id = $user->id;
            $like->image_id = (int)$image_id;

            //GUARDAR
            $like->save();

            return response()->json([
                'like' => $like
            ]);

        }else{
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }

    }



    public function dislike($image_id){
 //RECOGER DATOS DE USUARIO E IMAGEN

$user = \Auth::user();

 //CONDICION PARA VER SI EL LIKE YA EXISTE EN LA DB
$like = Like::where('user_id', $user->id)
                ->where('image_id', $image_id)
                ->first();

    if($like) {

     //ELIMINAR LIKE
    $like->delete();

    return response()->json([
        'like' => $like,
        'message' => 'Has dado dislike correctamente'
    ]);
    } else{
    return response()->json([
        'message' => 'El like no existe'
    ]);
    }
    }
}
