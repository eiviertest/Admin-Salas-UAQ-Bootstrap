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
        'instructor',
        'fecInCur',
        'fecFinCur',
        'reqCur',
        'durCur',
        'estado',
        'cupCur',
        'idSala'
    ];

    public function scopeFechaInicio($query, $fecha_inicio){
        if($fecha_inicio != '') {
            return $query->where('curso.fecInCur', '=', $fecha_inicio);
        }
    }
    
    public function scopeFechaFin($query, $fecha_fin){
        if($fecha_fin != '') {
            return $query->where('curso.fecFinCur', '=', $fecha_fin);
        }
    }

    public function scopeSala($query, $sala){
        if($sala != 0) {
            return $query->where('curso.idSala', '=', $sala);
        }
    }
    
    public function scopeEstado($query, $estado){
        if($estado != '') {
            return $query->where('curso.estado', '=', $estado);
        }
    }


    public function horarioscurso(){
        return $this->hasMany(HorarioCurso::class, 'idCur');
    }

    public function sala(){
        return $this->belongsTo(Sala::class, 'idSala');
    }

    public function personas() {
        return $this->belongsToMany(Persona::class, 'curso_persona');
    }
}
