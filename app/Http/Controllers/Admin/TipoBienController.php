<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Models\TipoBien;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TipoBienController extends ApiController
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
        $tiposBienes = TipoBien::select('id', 'nombre', 'descripcion')
            // ->when($request->filled('sorter.order'), function ($q) use ($request) {
            //     return $q->orderBy($request->sorter['field'], $request->sorter['order'] == 'descend' ? 'desc' : 'asc');
            // })
            //->paginate(10);
            ->get();
        //return response()->json($tiposBienes);
        return $this->showAll($tiposBienes);
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
            'nombre' => 'required|unique:tipo_biens',
            'descripcion' => 'required',
        ];
        $messages = [
            'nombre.required' => 'Este campo es obligatorio',
            'nombre.unique' => 'El bien' . $request->nombre . 'ya ha sido registrado',
            'descripcion.required' => 'Este campo es obligatorio',
        ];

        $this->validate($request, $rules, $messages);

        $tipobien = new TipoBien;
        $tipobien->nombre = $request->nombre;
        $tipobien->descripcion = $request->descripcion;
        $tipobien->save();

        return response()->json($tipobien);
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
        $tipobien = TipoBien::find($id);
        return response()->json($tipobien);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoBien $tipobien)
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

        $tipobien->nombre = $request->nombre;
        $tipobien->descripcion = $request->descripcion;
        $tipobien->save();

        return response()->json($tipobien);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipobien = TipoBien::find($id);
        $tipobien->delete();
        return response()->json($tipobien);
    }
}
