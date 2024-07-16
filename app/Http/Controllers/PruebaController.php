<?php

namespace App\Http\Controllers;

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

class PruebaController extends Controller
{
    public function pruebapost(Request $request)
    {
        //debug($request);

        $fecha1 = Carbon::parse($request->fecha_ini);
        $fecha2 = Carbon::parse($request->fecha_fin);

        $informe = new Informe();
        //$informe->id = Str::uuid();
        $informe->titulo = $request->titulo;
        $informe->expediente = $request->expediente;
        $informe->situacionactual  = $request->situacion;
        $informe->producto_id = $request->tipoProd;
        $informe->palabraclave  = $request->palabras;
        $informe->fechainicioevento = $fecha1;
        $informe->fechafinalevento = $fecha2;
        $informe->municipio_id  = 107;
        $informe->usuariocreador_id = Auth::user()->id;
        $informe->agente  = "sdñ{flgjks{dfkjl";
        $informe->revisado  = 1;
        $informe->save();

        $antecedente=new Antecedente();
        $antecedente->descripcion=$request->antecedentes;
        $informe->antecedente()->save($antecedente);

        $observacion=new Observacion();
        $observacion->descripcion=$request->observacion;
        $informe->observacion()->save($observacion);

        $disco=Storage::disk('public');

        // foreach ($request->personas as $person) {
        //     $persona=new Persona();
        //     $persona->nombre=$person['nombre'];
        //     $persona->identidad=$person['identidad'];
        //     $persona->save();

        //     foreach ($person['foto'] as $foto) {
        //         $this->guardararchivo($foto['imge'],$disco,$foto['Id'],$persona,$persona->nombre);
        //     }
        //     $informe->personas()->attach($persona);
        // }
        // foreach ($request->bienes as $bie) {
        //     $bien=new Bien();
        //     $bien->tipobien_id=$bie['tipoId'];
        //     $bien->descripcion=$bie['descripcion'];
        //     $bien->save();
        //     foreach ($bie['foto'] as $foto) {
        //         $this->guardararchivo($foto['imge'],$disco,$foto['Id'],$bien,$bien->descripcion);
        //     }
        //     $informe->biens()->attach($bien);
        // }
        foreach ($request->archivoinf as $adjunto) {
            $this->guardararchivo($adjunto['imge'],$disco,$adjunto['Id'],$informe, $adjunto['name']);
        }
        // foreach ($request->ubicaciones as $ubicacio) {
        //     $ubicacion=new Ubicacion();
        //     $ubicacion->latitud=$ubicacio['Latitud'];
        //     $ubicacion->longitud=$ubicacio['Longitud'];
        //     $ubicacion->descripcion=$ubicacio['Descripcion'];
        //     $ubicacion->tipo=$ubicacio['Tipo'];

        //     $informe->ubicaciones()->save($ubicacion);
        // }

        $informe->ambitos()->attach($request->ambitos);

        return response()->json(['nombre_prese'=>'guardo']);
    }

    protected function guardararchivo($base64File,$disco,$idi,$modelo,$descripcion){
        $modelo_ = class_basename($modelo);
        //debug('modelo',$modelo_);
        // Extraer el tipo de archivo y los datos base64
        list($type, $data) = explode(';', $base64File);
        list(, $data) = explode(',', $data);
        // Obteniendo extención del archivo
        list(, $ext) = explode('/', $type);
        // Decodificar los datos base64
        $fileData = base64_decode($data);
        // Validar la extensión del archivo
        debug("es");
        if ($ext=='png' || $ext=='jpeg' || $modelo_=='Persona' && $modelo_=='Bien') {
            // Nombre del archivo
            $fileName = $idi . '_archivo.' . $ext; // Puedes cambiar la extensión según el tipo de archivo

            // Guardar el archivo en el sistema de archivos de Laravel
            $disco->put($fileName, $fileData);

            $adjunto=new Adjunto();
            $adjunto->url=$fileName;
            $adjunto->descripcion=$descripcion;
            $modelo->adjuntos()->save($adjunto);
        } else if(
            $ext=='png' ||
            $ext=='jpeg' ||
            $ext=='pdf' ||
            $ext=='vnd.openxmlformats-officedocument.wordprocessingml.document' ||
            $ext=='vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
            $ext=='vnd.openxmlformats-officedocument.presentationml.presentation' &&
            $modelo_=='Informe'){

            switch ($ext) {
                case 'vnd.openxmlformats-officedocument.wordprocessingml.document':
                    $ext='docx';
                    break;
                case 'vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                    $ext='xlsx';
                    break;
                case 'vnd.openxmlformats-officedocument.presentationml.presentation':
                    $ext='pptx';
                    break;
                default:
                    # code...
                    break;
            }
            // Nombre del archivo
            $fileName = $idi . '_archivo.' . $ext; // Puedes cambiar la extensión según el tipo de archivo

            // Guardar el archivo en el sistema de archivos de Laravel
            $disco->put($fileName, $fileData);

            $adjunto=new Adjunto();
            $adjunto->url=$fileName;
            $adjunto->descripcion=$descripcion;
            $modelo->adjuntos()->save($adjunto);

        } else{
            debug("archivo invalido",$ext);
        }
    }

    // protected function guardarpersonas($personas){

    //     foreach ($personas as $persona) {
    //         $person = new Persona();
    //         $person->nombre = $persona['nombre'];
    //         foreach ($persona['foto'] as $foto) {
    //             debug($foto);
    //             $this->guardararchivo($foto['imge'],$disco,$foto['Id']);
    //         }
    //     }


    // }
}

