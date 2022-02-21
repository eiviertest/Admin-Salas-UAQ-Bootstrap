<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Persona;
use App\Models\Estatus;
use App\Models\HorarioCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

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
                        ->persona($idPersona->idPer)
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
        //Formato Unix
        $hora_inicio = strtotime($request->horainicio);
        //Horas solicitadas.
        $horas_solicitadas = $request->horas_solicitadas;
        //Convertir horas a segundos
        $segundos = $horas_solicitadas * (60 * 60);
        //Hora de fin.
        $hora_fin = date('H:i:s', $hora_inicio + $segundos);
        $idPersona = $this->getIdPersona(Auth::user()->id);
        $nombreEstatus = "En proceso";
        $idEstatus = $this->getIdEstatus($nombreEstatus);
        if(empty($idEstatus)) {
            $estatus = new Estatus();
            $estatus->nomEst = 'En proceso';
            $estatus->save();
            $idEstatus = $estatus->idEst;
        }
        $cursos_registrados = HorarioCurso::select('c.idCur')
                            ->join('curso as c', 'c.idCur', '=', 'horario_curso.idCur')
                            ->where('c.idSala', '=', $request->idSala)
                            ->where('c.fecInCur', '=', [date($request->fecha)])
                            ->whereBetween('horario_curso.horIn', [$request->horainicio, $hora_fin])
                            ->get();
        if(empty($cursos_registrados)){
            $solicitudes_registradas = Solicitud::select('idSol')
                                        ->where('idSal', '=', $request->idSala)
                                        ->where('fecha', '=', [date($request->fecha)])
                                        ->whereBetween('horaIni', [$request->horainicio, $hora_fin])
                                        ->get();
            if(empty($solicitudes_registradas)) {
                try {
                    $solicitud = new Solicitud();
                    $solicitud->rutaSol = $request->rutaSol;
                    $solicitud->idSal = $request->idSala;
                    $solicitud->idPer = $idPersona->idPer;
                    $solicitud->idEst = $idEstatus->idEst;
                    $solicitud->fecha = $request->fecha;
                    $solicitud->horaIni = $request->horainicio;
                    $solicitud->horaFin = $hora_fin;
                    $solicitud->save();
                    return ['mensaje' => 'Ha sido guardado la solicitud'];
                } catch (exception $e) {
                    return $e->getMessage();
                }
            }else{
                return ['mensaje' => 'Una solicitud se encuentra registrada'];
            }
        }else{
                return ['mensaje' => 'Un curso se encuentra registrado'];
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
            $solicitud = Solicitud::findOrFail($request->idSol);
            $solicitud->idEst = $request->idEst;
            $solicitud->save();
            return ['mensaje' => 'Ha sido actualizada la solicitud'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    public function solicitud_persona(Request $request){
        if(!$request->ajax()) return redirect('/');
        $solicitudes = Solicitud::select(DB::raw('CONCAT(p.nomPer, " ", p.apeMatPer, " ", p.apePatPer) as nombre'), 'nomArea', 'nomEst', 'nomSala')
                        ->join('persona as p', 'p.idPer', '=', 'solicitud.idPer')
                        ->join('area as a', 'a.idArea', '=', 'p.idArea')
                        ->join('sala as s', 's.idSala', '=', 'solicitud.idSal')
                        ->join('estatus as es', 'es.idEst', '=', 'solicitud.idEst')
                        ->orderBy('nomArea', 'ASC')
                        ->get();
        $pdf = PDF::loadView('reportes.solicitud_persona', ['solicitudes    ' => $solicitudes]);
        return $pdf->download('solicitud_persona.pdf');
    }
}
