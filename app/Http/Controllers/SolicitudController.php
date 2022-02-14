<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Persona;
use App\Models\Estatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    /**
     * Lista las solicitudes del usuario logeado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $idPersona = $this->getIdPersona(Auth::user()->id);
        $solicitudes = Solicitud::select('s.nomSala as sala', 'solicitud.fecha as fecha', 'solicitud.hora as hora', 'e.nomEst as estado')
                        ->orderBy('solicitud.fecha', 'DESC')
                        ->join('sala as s', 'solicitud.idSal', '=', 's.idSala')
                        ->join('estatus as e', 'solicitud.idEst', '=', 'e.idEst')
                        ->where('e.nomEst', '!=', 'Aceptado')
                        ->persona($idPersona)
                        ->paginate(10);
        return ['solicitudes' => $solicitudes];
    }

    /**
     * Lista las solicitudes para administrador
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index_admin(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $solicitudes = Solicitud::select('s.nomSala as sala', 'solicitud.rutaSol', 'solicitud.fecha as fecha', 'solicitud.hora as hora', 'e.nomEst as estado')
                        ->orderBy('solicitud.fecha', 'DESC')
                        ->join('sala as s', 'solicitud.idSal', '=', 's.idSala')
                        ->join('estatus as e', 'solicitud.idEst', '=', 'e.idEst')
                        ->paginate(10);
        return ['solicitudes' => $solicitudes];
    }

    /**
     * Almacena una nueva solicitud
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $idPersona = $this->getIdPersona(Auth::user()->id);
        $nombreEstatus = "En proceso";
        $horafin = $request->horainicio + $request->horas_solicitadas;
        $idEstatus = $this->getIdEstatus($nombreEstatus);
        if($idEstatus == null) {
            $estatus = new Estatus();
            $estatus->nomEst = 'En proceso';
            $estatus->save();
            $idEstatus = $estatus->idEst;
        }
        try {
            $solicitud = new Solicitud();
            $solicitud->rutaSol = $request->rutaSol;
            $solicitud->idPer = $idPersona;
            $solicitud->idEst = $idEstatus;
            $solicitud->fecha = $request->fecha;
            $solicitud->horainicio = $request->horainicio;
            $solicitud->horafin = $horafin;
            $solicitud->save();
            return ['mensaje' => 'Ha sido guardado la solicitud'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Actualiza el estatus de la solicitud
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try {
            $solicitud = Solicitud::findOrFail($request->id);
            $solicitud->idEst = $request->idEst;
            $solicitud->save();
            return ['mensaje' => 'Ha sido actualizada la solicitud'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }
}
