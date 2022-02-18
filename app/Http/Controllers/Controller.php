<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Estatus;
use App\Models\Persona;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getIdEstatus($nombreEstatus) {
        $idEstado = Estatus::select('idEst')->where('nomEst', '=', 'En proceso')->first();
        return $idEstado;
    }

    public function getIdPersona($idUser) {
        $idPersona = Persona::select('idPer')->where('idUsr', '=', $idUser)->first();
        return $idPersona;
    }
}
