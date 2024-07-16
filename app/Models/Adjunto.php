<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adjunto extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'adjuntos_id',
        'adjuntos_type',
        'url',
        'descripcion',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $even_=new LogOptions;

        return LogOptions::defaults()
        ->logOnly(['adjuntos_id','adjuntos_type','url','descripcion'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . $even_->nombre_evento($eventName). " el adjunto")
        ->useLogName(Auth::user()->name); //comentado por que aun no se implementa la funcion de logueo
        // Chain fluent methods for configuration options
    }

    public function adjuntable(){
        return $this->morphTo();
    }

    // public function informes()
    // {
    //     return $this->belongsToMany('App\Models\Informe');
    // }

    //comando para guardar adjunto
    //$adjunto=new Adjunto;
    //$persona->adjuntos()->save($adjunto);
}
