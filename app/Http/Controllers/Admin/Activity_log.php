<?php

namespace App\Http\Controllers\Admin;

//use App\Models\Departamento;

use App\Http\Controllers\ApiController;
use App\Models\User;
//use App\Models\Municipio;
use App\Models\Institucion;
//use App\Models\PresentacionDroga;
//use App\Models\TipoDroga;
//use App\Models\Droga;
//use App\Models\Arma;
//use App\Models\EstructuraCriminal;
//use App\Models\TipoMunicion;
//use App\Models\Decomiso;
//use App\Models\Grafica;
//use App\Models\decomiso_droga;
//use App\Models\PresentacionPrecursor;
//use App\Models\Precursor;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;

class Activity_log extends ApiController
{
    public function __construct()
    {

    }
    public function index(Request $request)
    {
        $bitacoraLogs=Activity::select('*', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as formatted_date"))
        ->orderBy('created_at', 'desc')
        ->get();

        return $this->showAll($bitacoraLogs);
    }


}
