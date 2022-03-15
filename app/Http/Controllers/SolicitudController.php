<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Persona;
use App\Models\Estatus;
use App\Models\Area;
use App\Models\Curso;
use App\Models\HorarioCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;

class SolicitudController extends Controller
{

    public function calendar(Request $request)
    {
        $cursos = Curso::select(DB::raw('CONCAT(nomCur, " Inicio: ", DATE_FORMAT(h.horIn, "%H:%i"), " Fin: ", DATE_FORMAT(h.horFin, "%H:%i")) as title'), 'fecInCur as start', 'fecFinCur as end')
                        ->join('horario_curso as h', 'curso.idCur', 'h.idCur')
                        ->sala($request->sala)
                        ->fechaInicio($request->fecha)
                        ->where('curso.estado', '=', 1)
                        ->get();
        $solicitudes = Solicitud::select(DB::raw('CONCAT("Solicitud", " Inicio: ", DATE_FORMAT(horaIni, "%H:%i"), " Fin: ", DATE_FORMAT(horaFin, "%H:%i")) as title'), 'solicitud.fecha as start', 'solicitud.fecha as end')
                        ->horaInicio($request->horaInicio)
                        ->horaFin($request->horaFin)
                        ->sala($request->sala)
                        ->fecha($request->fecha)
                        ->get();
        $eventos = array_merge($solicitudes->toarray(), $cursos->toarray());
        return ['eventos' => $eventos];
    }

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
        $solicitudes = Solicitud::select('s.nomSala as sala', 'solicitud.fecha as fecha', 'solicitud.horaIni', 'solicitud.horaFin', 'e.nomEst as estado')
                        ->orderBy('e.nomEst', 'ASC')
                        ->join('sala as s', 'solicitud.idSal', '=', 's.idSala')
                        ->join('estatus as e', 'solicitud.idEst', '=', 'e.idEst')
                        ->persona($idPersona->idPer)
                        ->paginate(10);
        return [
            'pagination' => [
                'total' => $solicitudes->total(),
                'current_page' => $solicitudes->currentPage(),
                'per_page' => $solicitudes->perPage(),
                'last_page' => $solicitudes->lastPage(),
                'from' => $solicitudes->firstItem(),
                'to' => $solicitudes->lastItem()
            ],
            'solicitudes' => $solicitudes];
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
        $solicitudes = Solicitud::select('idSol', 's.nomSala as sala', 'p.telPer', 'solicitud.fecha as fecha', 'solicitud.horaIni', 'solicitud.horaFin', 'e.nomEst as estado')
                        ->orderBy('solicitud.fecha', 'DESC')
                        ->join('sala as s', 'solicitud.idSal', '=', 's.idSala')
                        ->join('persona as p', 'p.idPer', '=', 'solicitud.idPer')
                        ->join('estatus as e', 'solicitud.idEst', '=', 'e.idEst')
                        ->paginate(10);
        return [
            'pagination' => [
                'total' => $solicitudes->total(),
                'current_page' => $solicitudes->currentPage(),
                'per_page' => $solicitudes->perPage(),
                'last_page' => $solicitudes->lastPage(),
                'from' => $solicitudes->firstItem(),
                'to' => $solicitudes->lastItem()
            ],
            'solicitudes' => $solicitudes];
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
        if($request->hasFile(key:'rutaSol')){
            $fileName = $request->rutaSol->getClientOriginalName();
        }else{
            $filename = null;
        }
        //Formato Unix
        $hora_inicio = strtotime($request->horaIni);
        //Horas solicitadas.
        $horas_solicitadas = $request->horas_solicitadas;
        //Convertir horas a segundos
        $segundos = $horas_solicitadas * (60 * 60);
        //Hora de fin.
        $hora_fin = $request->horaFin;
        $idPersona = $this->getIdPersona(Auth::user()->id);
        $nombreEstatus = "En proceso";
        $idEstatus = $this->getIdEstatus($nombreEstatus);
        $uuid = (string) Str::uuid();
        $cursos_registrados = HorarioCurso::select('c.nomCur')
                            ->join('curso as c', 'c.idCur', '=', 'horario_curso.idCur')
                            ->where('c.fecInCur', '<=', [date($request->fecha)])
                            ->Where('c.fecFinCur', '>=', [date($request->fecha)])
                            ->where('c.idSala', '=', $request->idSala)
                            ->where(function ($query) use ($request, $hora_fin) {
                                $query->where('horIn', '<=', $request->horaIni)
                                    ->where('horFin', '<=', $request->horaFin)
                                    ->whereBetween('horIn', [$request->horaIni, $hora_fin])
                                    ->orWhereRaw('horFin between ? and ?', [$request->horaIni, $hora_fin]);
                            })
                            ->get();
        if(count($cursos_registrados) == 0){
            $solicitudes_registradas = Solicitud::select('idSol')
                                        ->where('idSal', '=', $request->idSala)
                                        ->where('fecha', '=', [date($request->fecha)])
                                        ->where(function ($query) use ($request, $hora_fin) {
                                            $query->whereBetween('horaIni', [$request->horaIni, $hora_fin])
                                                ->orWhereRaw('horaFin between ? and ?', [$request->horaIni, $hora_fin])
                                                ->orWhereRaw('horaIni <= ? and horaFin >= ?', [$request->horaIni, $hora_fin]);
                                        })
                                        ->get();
            if(count($solicitudes_registradas) == 0) {
                try {
                    $horaFinUnix = strtotime($hora_fin);
                    $solicitud = new Solicitud();
                    if($request->hasFile(key:'rutaSol')){
                        //$solicitud->rutaSol = $request->file(key: 'rutaSol')->store(path: 'formatosSol');
                        $solicitud->rutaSol = time() . '_' . $request->file(key:'rutaSol')->getClientOriginalName();
                        $request->file(key:'rutaSol')->storeAs(path:'formatosSol', name:$solicitud->rutaSol); 
                    }else{
                        $solicitud->rutaSol = null;
                    }
                    $solicitud->uuid = $uuid;
                    $solicitud->idSal = $request->idSala;
                    $solicitud->idPer = $idPersona->idPer;
                    $solicitud->idEst = $idEstatus->idEst;
                    $solicitud->fecha = $request->fecha;
                    $solicitud->horaIni = $request->horaIni;
                    $solicitud->horaFin = $request->horaFin;
                    $solicitud->save();
                    return [
                        'code' => 1,
                        'mensaje' => 'Ha sido guardada la solicitud'];
                } catch (exception $e) {
                    return $e->getMessage();
                }
            }else{
                return [
                    'code' => 2,
                    'mensaje' => 'Una solicitud se encuentra registrada'];
            }
        }else{
                return [
                    'code' => 2,
                    'mensaje' => 'Un curso se encuentra registrado'];
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

    public function area_solicitudes_detalle($idArea){
        $solicitudes = Solicitud::select('idSol', DB::raw('CONCAT(p.nomPer, " ", p.apeMatPer, " ", p.apePatPer) as nombre'), 'nomEst', 'nomSala')
                        ->join('persona as p', 'p.idPer', '=', 'solicitud.idPer')
                        ->join('area as a', 'a.idArea', '=', 'p.idArea')
                        ->join('sala as s', 's.idSala', '=', 'solicitud.idSal')
                        ->join('estatus as es', 'es.idEst', '=', 'solicitud.idEst')
                        ->where('a.idArea', '=', $idArea)
                        ->orderBy('nomArea', 'ASC')
                        ->get();
        return ['solicitudes' => $solicitudes];
    }

    public function area_solicitudes_detalle_pdf($idArea) {
        $area = Area::select('nomArea')->where('idArea', '=', $idArea)->first();
        $solicitudes = $this->area_solicitudes_detalle($idArea);
        $pdf = PDF::loadView('reportes.solicitud_persona', ['solicitudes' => $solicitudes['solicitudes'], 'area' => $area]);
        return $pdf->download('area_solicitudes_detalle.pdf');
    }
}
