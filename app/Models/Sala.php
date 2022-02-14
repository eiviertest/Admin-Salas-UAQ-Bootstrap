<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    protected $table = 'sala';

    protected $primaryKey = 'idSala';

    protected $fillable = [
        'nomSala'
    ];

    public function cursos(){
        return $this->hasMany(Curso::class, 'idSala');
    }
}
