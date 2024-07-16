<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Models\Ambito;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AmbitoController extends ApiController
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
        $ambitos = Ambito::select('id', 'nombre', 'descripcion')
            // ->when($request->filled('sorter.order'), function ($q) use ($request) {
            //     return $q->orderBy($request->sorter['field'], $request->sorter['order'] == 'descend' ? 'desc' : 'asc');
            // })
            //->paginate(10);
            ->get();
        //return response()->json($ambitos);
        return $this->showAll($ambitos);
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
            'nombre' => 'required|unique:ambitos',
            'descripcion' => 'required',
        ];
        $messages = [
            'nombre.required' => 'Este campo es obligatorio',
            'nombre.unique' => 'El ambito' . $request->nombre . 'ya ha sido registrado',
            'descripcion.required' => 'Este campo es obligatorio',
        ];

        $this->validate($request, $rules, $messages);
        $ambito = new Ambito;
        $ambito->nombre = $request->nombre;
        $ambito->descripcion = $request->descripcion;
        $ambito->save();

        return response()->json($ambito);
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
        $ambito=Ambito::find($id);
        return response()->json($ambito);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ambito $ambito)
    {
        $rules = [
            'nombre' => 'required',
            'descripcion' => 'required',
        ];
        $messages = [
            'nombre.required' => 'Este campo es obligatorio',
            'descripcion.required' => 'Este campo es obligatorio',

        ];

        $this->validate($request, $rules, $messages);

        $ambito->nombre = $request->nombre;
        $ambito->descripcion = $request->descripcion;
        $ambito->save();

        return response()->json($ambito);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ambito=Ambito::find($id);
        $ambito->delete();
        return response()->json($ambito);
    }

}
