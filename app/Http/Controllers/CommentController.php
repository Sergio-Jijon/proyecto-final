<?php

namespace App\Http\Controllers;
use App\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function _construct(){
        $this->middleware('auth');
    }

    public function save (Request $request) {

        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);


        //RECOGER DATOS
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

       //var_dump($content);
      // die();
 //asignar los valores obtenidos al nuevo objeto a guardar
    $comment = new Comment();
    $comment->user_id = $user->id;
    $comment->image_id = $image_id;
    $comment->content = $content;
        //GUARDAR EN BASE DE DATOS
    $comment->save();
      //REDIRECCION
    return redirect()->route('image.detail', ['id' => $image_id])
                    ->with([
                        'message' => 'Has publicado tu comentario correctamente!!'
                    ]);
    }

    public function delete($id){
        //Conseguir los datos del usuario logueado
        $user = \Auth::user();

        //Conseguir objeto del comentario que llega por parametro
        $comment = Comment::find($id);

        //Comprobar si soy el dueño del comentario o de la publicacion
        if($user && ($comment->user_id == $user->id ||
        $comment->image->user_id == $user->id)){
            $comment->delete();

            return redirect()->route('image.detail', ['id' => $comment->image->id])
                    ->with([
                        'message' => 'Comentario eliminado correctamente!!'
                    ]);
        }else{
            return redirect()->route('image.detail', ['id' => $comment->image->id])
            ->with([
                'message' => 'COMENTARIO NO ELIMINADO!!'
            ]);
        }
    }
}
