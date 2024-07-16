<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'nombre',
    ];



    public function municipios(){
        return $this->hasMany('App\Models\Municipio');
    }

}
