<?php

namespace App\Http\Controllers;

use App\Models\Bien;
use App\Models\Informe;
use App\Models\TipoBien;
use Illuminate\Http\Request;

class BienController extends Controller
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

    public function indexBienesInforme($id)
    {
        // $bienes = Informe::with(['biens' => ['adjuntos','tipobien']])->find($id)->biens; // para agrupar terceras relaciones
        $bienes = Informe::with( ['biens:id,descripcion,tipobien_id' => ['tipobien']] )->find($id)->biens; // para traer unicamente las personas
        return response()->json($bienes);
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

         $bien = new Bien();
         $bien->descripcion = $request->descripcion;
         $bien->tipobien_id = $request->tipobien_id;
         $bien->save();

         $informe->biens()->attach($bien);
         return response()->json($bien->id);
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
        $bien=Bien::with('adjuntos')->find($id);
        return response()->json($bien);
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
        $bien = Bien::find($id);
        $bien->descripcion = $request->descripcion;
        $bien->tipobien_id = $request->tipo;
        $bien->save();
        return response()->json($bien->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bien = Bien::find($id);
        $bien->adjuntos()->delete();
        $bien->delete();
        return response()->json('la persona ha sido borrada');

    }

    public function parametrosBien()
    {
        $tiposBien = TipoBien::all('id','nombre');
        return response()->json($tiposBien);
    }
}
