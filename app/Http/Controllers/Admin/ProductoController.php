<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        $productos = Producto::select('id', 'nombre', 'descripcion')->get();
        return $this->showAll($productos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre'=> 'required|unique:productos',
            'descripcion'=> 'required',
        ];
        $messages = [
            'nombre.required' => 'Este campo es obligatorio',
            'nombre.unique' => 'El producto'.$request->nombre. 'ya ha sido registrado',
            'descripcion.required' => 'Este campo es obligatorio',
        ];

        $this->validate($request, $rules,$messages);

        $producto=new Producto;
        $producto->nombre=$request->nombre;
        $producto->descripcion=$request->descripcion;
        $producto->save();


        return response()->json($producto);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto=Producto::find($id);
        return response()->json($producto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $rules = [
            'nombre'=> 'required',
            'descripcion'=> 'required',
        ];
        $messages = [
            'nombre.required' => 'Este campo es obligatorio',
            'descripcion.required' => 'Este campo es obligatorio',

        ];

        $this->validate($request, $rules, $messages);

        $producto->nombre=$request->nombre;
        $producto->descripcion=$request->descripcion;
        $producto->save();

        return response()->json($producto);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto=Producto::find($id);
        $producto->delete();
        return response()->json(['parametro' => $producto]);
    }
}
