<?php

namespace App\Http\Controllers;

use App\Models\Informe;
use App\Models\Ubicacion;
use Illuminate\Http\Request;

class UbicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //dd($request);
        //$informe = Informe::find($request->idInforme);
        $ubicaciones = Informe::with(['ubicaciones'])->find($id)->ubicaciones;
        return response()->json(['ubicaciones' => $ubicaciones]);
    }

    public function ubicacionesinforme($id)
    {
        //dd($request);
        //$informe = Informe::find($request->idInforme);
        $ubicaciones = Informe::with(['ubicaciones'])->find($id)->ubicaciones;
        return response()->json(['ubicaciones' => $ubicaciones]);
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

        $ubicacion = new Ubicacion();
        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->descripcion = $request->descripcion;
        $ubicacion->tipo = 1;

        $informe->ubicaciones()->save($ubicacion);

        return response()->json(['ubicacion' => $ubicacion, 'mensage' => 'se guardo con exito']);
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
        $ubicacion = Ubicacion::find($id);

        $ubicacion->latitud = $request->latitud;
        $ubicacion->longitud = $request->longitud;
        $ubicacion->descripcion = $request->descripcion;
        $ubicacion->tipo = 1;
        $ubicacion->save();

        return response()->json(['ubicacion' => $ubicacion, 'mensage' => 'se actualizo con exito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ubicacion = Ubicacion::find($id);
        $ubicacion->delete();
        return response()->json(['ubicacion' => $ubicacion, 'mensage' => 'se borro con exito']);
    }
}
