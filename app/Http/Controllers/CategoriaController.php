<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use Exception;
use Session; 

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $categorias = Categoria::all();
    return view("categoria.index",compact("categorias"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        //$this->middleware('auth')->only(["index"]);
        $this->middleware('auth');
    }

    public function create()
    {
        return view ("categoria.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        try{
            $c = new Categoria;
            $c ->nombre=$r->nombre;
            $c ->save();
            $m = ["msj"=>"Categoria $r->nombre Creada Correctamente", "clase"=>"success"];
        }catch(Exeption $e){
            $m = ["msj"=>"Error Al Insertar La Categoria $r->nombre", "clase"=>"danger"];
        }
        Session::flash("m", $m);
        return redirect(route("categoria.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $c = Categoria::findOrFail($id);
            $c ->delete();
            $m = [
                "msj"=>"Registro Eliminado", "clase"=>"success"];
        }catch(Exeption $e){
            $m = ["msj"=>"Error Al Eliminar El Registro","clase"=>"danger"];
        }
        Session::flash("m", $m);
        return redirect(route("categoria.index"));
    }
}
