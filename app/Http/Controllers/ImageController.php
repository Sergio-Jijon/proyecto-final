<?php

namespace App\Http\Controllers;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function _construct(){
        $this->middleware('auth');
    }


    public function create(){
        return view('image.create');
    }

    public function save(Request $request){

        //RECOGER DATOS
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        //VALIDAR

        $validate = $this->validate($request ,[
            'description' => 'required',
            'image_path' => 'required|image'
        ]);


        //ASIGNAR VALORES A NUEVO OBJETO
            $user = \Auth::user();
            $image = new Image();
            $image->user_id = $user->id;
            $image->image_path = $image_path;
            $image->description = $description;

        //SUBIR FICHERO

        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }
        $image->save();

        return redirect()->route('home')->with([
            'message' => 'La foto ha sido subida correctamente.!'
        ]);
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function detail($id){
        $image =Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }
}
