<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bien extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'tipobien_id',
        'descripcion',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        $even_=new LogOptions;

        return LogOptions::defaults()
        ->logOnly(['tipobien_id','descripcion'])
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . $even_->nombre_evento($eventName). " el bien")
        ->useLogName(Auth::user()->name);
        // Chain fluent methods for configuration options
    }

    //Relación uno a muchos polimorfica
    public function adjuntos(){
        return $this->morphMany('App\Models\Adjunto', 'adjuntable');
    }

    public function tipobien(){
        return $this->belongsTo('App\Models\TipoBien');
    }

    public function informes()
    {
        return $this->belongsToMany('App\Models\Informe');
    }
}
