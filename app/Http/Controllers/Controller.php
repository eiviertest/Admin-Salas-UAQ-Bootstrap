<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Estatus;
use App\Models\Persona;
use App\Models\Area;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Identificador de un estatus
     *
     * @param  string estatus
     * @return collection dataEstatus
     */
    public function getIdEstatus($nombreEstatus) {
        $idEstado = Estatus::select('idEst')->where('nomEst', '=', 'En proceso')->first();
        return $idEstado;
    }

    /**
     * Identificador de una persona
     *
     * @param  int idUser
     * @return collection dataPersona
     */
    public function getIdPersona($idUser) {
        $idPersona = Persona::select('idPer')->where('idUsr', '=', $idUser)->first();
        return $idPersona;
    }

    /**
     * Identificador de un area
     *
     * @param  string area
     * @return collection dataArea
     */
    public function getIdArea($nomArea) {
        $idArea = Area::select('idArea')->where('nomArea', '=', $nomArea)->first();
        return $idArea;
    }
}
