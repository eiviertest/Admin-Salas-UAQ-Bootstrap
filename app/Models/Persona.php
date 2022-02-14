<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';

    protected $primaryKey = 'idPer';

    protected $fillable = [
        'nomPer',
        'apePatPer',
        'apeMatPer',
        'telPer',
        'idArea'
    ];

    public function categoria(){
        return $this->belongsTo(Area::class, 'idArea');
    }

    public function solicitudes(){
        return $this->hasMany(Solicitud::class, 'idPer');
    }

    public function cursos() {
        return $this->belongsToMany(Curso::clas, 'curso_persona');
    }

    public function area(){
        return $this->hasOne(Area::class);
    }
}
