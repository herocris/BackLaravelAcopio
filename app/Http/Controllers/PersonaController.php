<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Informe;
use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function indexPersonasInforme($id)
    {
        $personas = Informe::with(['personas:id,nombre,identidad'])->find($id)->personas; // para traer unicamente las personas
        return response()->json($personas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $informe = Informe::find($request->informe_id);

        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->identidad = $request->identidad;
        $persona->save();

        $informe->personas()->attach($persona);
        return response()->json($persona->id);
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
        $persona=Persona::with('adjuntos')->select('id', 'nombre', 'identidad')->find($id);
        return response()->json($persona);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $persona = Persona::find($id);
        $persona->nombre = $request->nombre;
        $persona->identidad = $request->identidad;
        $persona->save();
        return response()->json($persona->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $persona = Persona::find($id);
        $persona->adjuntos()->delete();
        $persona->delete();
        return response()->json(['personas' => 'la persona ha sido borrada']);
    }
}
