<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Informe extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    //protected $keyType = 'string';

    protected $fillable = [
        'id',
        'expediente',
        'titulo',
        'producto_id',
        'fechainicioevento',
        'fechafinalevento',
        'municipio_id',
        'situacionactual',
        'palabraclave',
        'revisado',
        'agente_id',
        'usuariocreador_id',
        'usuarioeditor_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $even_=new LogOptions;

        return LogOptions::defaults()
        ->logOnly(['usuariocreador_id','titulo','producto_id','fechainicioevento',
        'fechafinalevento','latitud','longitud','municipio_id','situacionactual','usuarioeditor_id',
        'palabraclave','revisado','agente'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . $even_->nombre_evento($eventName). " el informe")
        ->useLogName(Auth::user()->name);
        // Chain fluent methods for configuration options
    }

    //Relación uno a muchos polimorfica
    public function adjuntos(){
        return $this->morphMany('App\Models\Adjunto', 'adjuntable');
    }

    //Relaciónes de uno a muchos
    public function creador(){
        return $this->belongsTo('App\Models\User','usuariocreador_id');
    }
    public function agente(){
        return $this->belongsTo('App\Models\User','agente_id');
    }
    public function editor(){
        return $this->belongsTo('App\Models\User','usuarioeditor_id');
    }
    public function producto(){
        return $this->belongsTo('App\Models\Producto');
    }
    public function municipio(){
        return $this->belongsTo('App\Models\Municipio','municipio_id');
    }

    //Relaciones de uno a uno
    public function antecedente(){
        return $this->hasOne('App\Models\Antecedente');
    }
    public function observacion(){
        return $this->hasOne('App\Models\Observacion');
    }

    //Relaciones de uno a muchos
    public function ubicaciones(){
        return $this->hasMany('App\Models\Ubicacion');
    }

    //Relaciones de muchos a muchos
    public function personas(){
        return $this->belongsToMany('App\Models\Persona');
    }
    public function ambitos(){
        return $this->belongsToMany('App\Models\Ambito');
    }
    public function biens(){
        return $this->belongsToMany('App\Models\Bien');
    }

    //para traer la relacion de una persona en especifico
    //$unapersona->relacionespersonales()->with('persona','relacion_personal','con_persona')->get()
}
