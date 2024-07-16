<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Antecedente extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'informe_id',
        'descripcion',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $even_=new LogOptions;

        return LogOptions::defaults()
        ->logOnly(['informe_id','descripcion'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . $even_->nombre_evento($eventName). " el antecedente")
        ->useLogName(Auth::user()->name);
        // Chain fluent methods for configuration options
    }

    //Relación de uno a uno con Informe
    public function informe(){
        return $this->belongsTo('App\Models\Informe');
    }
}
