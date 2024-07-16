<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'nombre',
        'identidad',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $even_=new LogOptions;

        return LogOptions::defaults()
        ->logOnly(['nombre','identidad'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . $even_->nombre_evento($eventName). " la persona")
        ->useLogName(Auth::user()->name);
        // Chain fluent methods for configuration options
    }

    //Relación uno a muchos polimorfica
    public function adjuntos(){
        return $this->morphMany('App\Models\Adjunto', 'adjuntable');
    }

    //Relación muchos a muchos con Relaciones personales
    public function relacionespersonales(){
        return $this->hasMany('App\Models\RelacionConPersona');
    }

    public function informes()
    {
        return $this->belongsToMany('App\Models\Informe');
    }


}

//para traer la relacion de una persona en especifico
//$unapersona->relacionespersonales()->with('persona','relacion_personal','con_persona')->get()

//para traer a todas las personas con todas sus relaciones
//Persona::with('relacionespersonales.con_persona','relacionespersonales.persona','relacionespersonales.relacion_personal')->get()
