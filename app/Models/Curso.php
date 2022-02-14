<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'curso';

    protected $primaryKey = 'idCur';

    protected $fillable = [
        'nomCur',
        'fecInCur',
        'fecFinCur',
        'reqCur',
        'durCur',
        'estado',
        'cupCur',
        'idSala'
    ];

    public function horarioscurso(){
        return $this->hasMany(HorarioCurso::class, 'idCur');
    }

    public function sala(){
        return $this->belongsTo(Sala::class, 'idSala');
    }

    public function personas() {
        return $this->belongsToMany(Persona::clas, 'curso_persona');
    }
}
