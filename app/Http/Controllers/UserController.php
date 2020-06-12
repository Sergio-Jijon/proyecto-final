<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function _construct(){
        $this->middleware('auth');
    }

    public function config(){
        return view('/user.config');
    }

    public function update(Request $request){

        //CONSEGUIR USUARIO IDENTIFICADO

        $user = \Auth::user();
        $id = $user->id;

        //VALIDAR DATOS DEL FORMULARIO
        $validate = $this -> validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id
        ]);

        //RECOGER DATOS DEL FORMULARIO
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        //ASIGNAR NUEVOS VALORES AL OBJETO USUARIO

        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        //SUBIR LA IMAGEN
        $image_path = $request->file('image_path');
        if($image_path){

            //poner nombre unico
            $image_path_name = time().$image_path->getClientOriginalName();
            //GUARDAR EN LA CARPETA STORAGE/APP/USERS
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //SETEAR EL NOMBRE DE LA IMAGEN EN EL OBJETO
            $user->image = $image_path_name;
        }

        //EJECUTAR CONSULTA Y CAMBIOS EN LA BASE DE DATOS

            $user->update();

            return redirect()->route('config')
                            ->with(['message'=>'Usuario actualizado correctamente']);

    }

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
}
