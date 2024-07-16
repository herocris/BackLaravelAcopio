<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\TipoBien;
use App\Models\User;
use App\Models\Adjunto;
use App\Models\Ambito;
use App\Models\Antecedente;
use App\Models\Bien;
use App\Models\Informe;
use App\Models\Observacion;
use App\Models\Persona;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class InformeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$informes = Informe::with('antecedente', 'observacion', 'creador', 'editor', 'producto', 'personas', 'ambitos:ambito', 'biens', 'adjuntos')//para traer propiedades especificas ambitos:ambito
        $informes = Informe::with('creador', 'ambitos:nombre', 'producto:id,nombre') //para traer propiedades especificas ambitos:ambito
            // ->when($request->filled('filters'), function ($q) use ($request) { //consulta para con filtros especificos de una columna
            //     if ($request->filled('filters.producto')) {
            //         $q->whereHas('producto', function (Builder $query) use ($request) {
            //             $query->whereIn('producto', $request->filters['producto']);
            //         });
            //     }
            //     if ($request->filled('filters.ambitos')) {
            //         $q->whereHas('ambitos', function (Builder $query) use ($request) {
            //             $query->whereIn('ambito', $request->filters['ambitos']);
            //         });
            //     }
            //})->select('*', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as formatted_date"))
            //->paginate(10);
            ->select('*', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as formatted_date"))
            ->get();
        //return response()->json($informes);
        return $this->showAll($informes);

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
        $fecha1 = Carbon::parse($request->fechas[0]);
        $fecha2 = Carbon::parse($request->fechas[1]);

        $informe = new Informe();
        $informe->titulo = $request->titulo;
        $informe->expediente = $request->expediente;
        $informe->situacionactual  = $request->situacionactual;
        $informe->producto_id = $request->producto_id;
        $informe->fechainicioevento = $fecha1;
        $informe->fechafinalevento = $fecha2;
        $informe->usuariocreador_id = Auth::user()->id;
        $informe->revisado  = 0; //

        $informe->save();

        $antecedente = new Antecedente();
        $antecedente->descripcion = $request->antecedente;
        $informe->antecedente()->save($antecedente);

        $observacion = new Observacion();
        $observacion->descripcion = $request->observacion;
        $informe->observacion()->save($observacion);

        $ambitos = $request->ambitos;
        $ambitos = array_map(fn ($element) => Ambito::where('nombre', $element)->first()->id, $ambitos);
        $informe->ambitos()->sync($ambitos);

        return response()->json($informe->id);
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
        //$informe = Informe::with('personas.adjuntos', 'biens.adjuntos', 'antecedente', 'biens.tipobien', 'adjuntos', 'ubicaciones', 'ambitos', 'antecedente', 'observacion')->findOrFail($id);
        $informe = Informe::with('antecedente', 'biens.tipobien', 'adjuntos', 'ubicaciones', 'ambitos', 'antecedente', 'observacion')->findOrFail($id);
        return response()->json($informe);
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
        $fecha1 = Carbon::parse($request->fechas[0]);
        $fecha2 = Carbon::parse($request->fechas[1]);

        $informe = Informe::find($id);
        $informe->titulo = $request->titulo;
        $informe->expediente = $request->expediente;
        $informe->situacionactual  = $request->situacionactual;
        $informe->producto_id = $request->producto_id;
        $informe->fechainicioevento = $fecha1;
        $informe->fechafinalevento = $fecha2;
        $informe->usuarioeditor_id = Auth::user()->id;;
        $informe->save();

        $ambitos = $request->ambitos;
        $ambitos = array_map(fn ($element) => Ambito::where('nombre', $element)->first()->id, $ambitos);
        $informe->ambitos()->sync($ambitos);

        $antecedente = $informe->antecedente;
        $antecedente->descripcion = $request->antecedente;
        $antecedente->update();

        $observacion = $informe->observacion;
        $observacion->descripcion = $request->observacion;
        $observacion->update();

        return response()->json($informe);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $informe = Informe::find($id);
        $informe->ubicaciones()->delete();
        $informe->adjuntos()->delete();
        $informe->personas()->delete();
        $informe->biens()->delete();
        $informe->delete();
        return response()->json('borro correctamente');
        //return redirect()->route('informe.index');
    }


    public function parametrosInf()
    {
        $productos = Producto::all('id', 'nombre', 'descripcion');
        $ambitos = Ambito::all('id', 'nombre', 'descripcion');

        return response()->json(['productos' => $productos, 'ambitos' => $ambitos]);
    }
    /////////////////////


}
