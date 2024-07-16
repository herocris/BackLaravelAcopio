<?php

namespace App\Http\Controllers;

use App\Models\Adjunto;
use App\Models\Bien;
use App\Models\Informe;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdjuntoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $tipo = $request->tipo;
        $modelo = $tipo=='persona'?Persona::find($request->modelo_id):($tipo=='bien'?Bien::find($request->modelo_id):Informe::find($request->modelo_id));
        $disco = Storage::disk('public');
        foreach ($request->file('archivosper') as $archivo) {
             $ruta = $disco->put('', $archivo);
             $adjunto = new Adjunto();
             $adjunto->url = $ruta;
             $adjunto->descripcion = $archivo->getClientOriginalName();
             $modelo->adjuntos()->save($adjunto);
        }
        return response()->json($modelo->adjuntos);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $archivo = Adjunto::find($id);
        $disco = Storage::disk('public');

        if ($disco->exists($archivo->url)) {
            $disco->delete($archivo->url); //borrando del storage
            $archivo->delete(); //borrando de la base de datos
        }
        return response()->json('se borro correctamente');
    }
}
