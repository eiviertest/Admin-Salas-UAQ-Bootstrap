<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioCurso extends Model
{
    use HasFactory;

    protected $table = 'horario_curso';

    protected $primaryKey = 'idHor';

    protected $fillable = [
        'horIn',
        'horFin',
        'idCur'
    ];

    public function curso(){
        return $this->belongsTo(Curso::class, 'idCur');
    }
}
