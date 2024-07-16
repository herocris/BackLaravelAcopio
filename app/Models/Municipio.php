<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'departamento_id',
    ];

    public function departamento(){
        return $this->belongsTo('App\Models\Departamento');
    }

    public function informes(){
        return $this->hasMany('App\Models\Informe');
    }
}
