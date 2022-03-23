<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitud';

    protected $primaryKey = 'idSol';

    protected $fillable = [
        'rutaSol',
        'uuid',
        'horaIni',
        'horaFin',
        'fecha',
        'idSal',
        'idPer',
        'idEst'
    ];

    public function scopeFecha($query, $fecha){
        if($fecha != '') {
            return $query->where('solicitud.fecha', '=', $fecha);
        }
    }
    
    public function scopeHoraInicio($query, $horaInicio){
        if($horaInicio != '') {
            return $query->where('solicitud.horaIni', '=', date('H:i:s', strtotime($horaInicio)));
        }
    }

    public function scopeHoraFin($query, $horaFin){
        if($horaFin != '') {
            return $query->where('solicitud.horaFin', '=', date('H:i:s', strtotime($horaFin)));
        }
    }

    public function scopeSala($query, $sala){
        if($sala != 0) {
            return $query->where('solicitud.idSal', '=', $sala);
        }
    }

    public function scopePersona($query, $idPer){
        if($idPer != 0) {
            return $query->where('solicitud.idPer', '=', $idPer);
        }
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
