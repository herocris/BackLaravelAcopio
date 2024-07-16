<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelacionConPersona extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'persona_id',
        'relacion_personal_id',
        'con_persona_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $even_=new LogOptions;

        return LogOptions::defaults()
        ->logOnly(['persona_id','relacion_personal_id','con_persona_id'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . $even_->nombre_evento($eventName). " una relacion entre personas")
        ->useLogName(Auth::user()->name);
        // Chain fluent methods for configuration options
    }


    public function persona(){
        return $this->belongsTo('App\Models\Persona','persona_id');//para establecer relacion de uno a muchos especificando la llave foranea para dar opcion a una segunda relacion
    }

    public function con_persona(){
        return $this->belongsTo('App\Models\Persona','con_persona_id');//segunda relacion
    }

    public function relacion_personal(){
        return $this->belongsTo('App\Models\RelacionPersonal');
    }

}
