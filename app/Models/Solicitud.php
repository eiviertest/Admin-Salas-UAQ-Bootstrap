<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitud';

    protected $primaryKey = 'idSolicitud';

    protected $fillable = [
        'rutaSol',
        'idSal',
        'idPer',
        'idEst'
    ];

    public function scopePersona($query, $idPer){
        return $query->where('solicitud.idPer', '=', $idPer);
    }

    public function persona(){
        return $this->belongsTo(Persona::class, 'idPer');
    }

    public function estatus(){
        return $this->hasOne(Estatus::class);
    }

    public function sala(){
        return $this->hasOne(Sala::class);
    }
}
