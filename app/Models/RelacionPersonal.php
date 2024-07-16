<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelacionPersonal extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'relacionpersonal',
        'descripcion',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $even_=new LogOptions;

        return LogOptions::defaults()
        ->logOnly(['relacionpersonal','descripcion'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . $even_->nombre_evento($eventName). " la relacion personal")
        ->useLogName(Auth::user()->name);
        // Chain fluent methods for configuration options
    }

    public function relacionespersonales(){
        return $this->hasMany('App\Models\RelacionConPersona');
    }
    //comando para crear registro con campo extra en tabla pivote
    //$persona->relacionespersonales()->attach([2=>['con_persona_id' =>89]]);
}
