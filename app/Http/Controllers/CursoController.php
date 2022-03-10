<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Support\Facades\DB;
use App\Models\HorarioCurso;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    /**
     * Lista los cursos a los cuales el usuario no se ha enrolado
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $idPersona = $this->getIdPersona(Auth::user()->id);
        $idPer = $idPersona->idPer;
        $cursos = Curso::select('curso.idCur', 'curso.nomCur', 'curso.fecInCur', 'curso.fecFinCur', 'curso.reqCur')
                        ->whereNotExists(function ($query) {
                            $query->select(DB::raw(1))->from('curso_persona')->whereColumn('curso_persona.idCur', 'curso.idCur');
                        })
                        ->orderBy('nomCur', 'ASC')->where('curso.estado', '=', '1')->paginate(9);
        return [
            'pagination' => [
                'total' => $cursos->total(),
                'current_page' => $cursos->currentPage(),
                'per_page' => $cursos->perPage(),
                'last_page' => $cursos->lastPage(),
                'from' => $cursos->firstItem(),
                'to' => $cursos->lastItem()
            ],
            'cursos' => $cursos];
    }

    /**
     * Lista los cursos activos para administrador
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index_admin(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $cursos = Curso::select('curso.idCur', 'curso.nomCur', 'curso.fecInCur', 'curso.fecFinCur', 'curso.reqCur', 'curso.estado')
                        ->fechaInicio($request->fecha_inicio)
                        ->fechaFin($request->fecha_fin)
                        ->estado($request->estatus)
                        ->sala($request->sala)
                        ->orderBy('nomCur', 'ASC')->paginate(10);
        return [
            'pagination' => [
                'total' => $cursos->total(),
                'current_page' => $cursos->currentPage(),
                'per_page' => $cursos->perPage(),
                'last_page' => $cursos->lastPage(),
                'from' => $cursos->firstItem(),
                'to' => $cursos->lastItem()
            ],
            'cursos' => $cursos];
    }

    /**
     * Retorna todos los cursos activos sin paginacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function catalogoCurso(Request $request){
        if(!$request->ajax()) return redirect('/');   
        $cursos = Curso::select('curso.idCur', 'curso.nomCur')
                        ->orderBy('nomCur', 'ASC')->get();
        return ['cursos' => $cursos];
    }

    /**
     * Valida los datos de curso.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function validarDatos($request) {
        $request->validate([
            'curso.nomCur' => 'required|string|max:200',
            'curso.fecInCur' => 'required|date',
            'curso.fecFinCur' => 'required|date',
            'curso.reqCur' => 'required|string|max:100',
            'curso.instructor' => 'required|string|max:255',
            'curso.cupCur' => 'required|int|max:15',
            'curso.idSala' => 'required|int|exists:sala,idSala',
            'curso.horarioscurso' => 'required|array|min:1'
        ]);
    }

    /**
     * Valida los datos de curso.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function validarDatosUpdate($request) {
        $request->validate([
            'curso.fecInCur' => 'required|date',
            'curso.fecFinCur' => 'required|date',
            'curso.instructor' => 'required|string|max:255',
        ]);
    }
    
    /**
     * Retorna los cursos entre dos fechas, ciertos horarios y sala.
     *
     * @param date fecha_inicio fecha_fin
     * @param array horarios
     * @param int sala
     * @return array cursos
     */
    public function cursos_registrados($fecha_inicio, $fecha_fin, $horario, $sala){
        $cursos = Curso::select('curso.nomCur', 'horIn', 'horFin')
                        ->join('horario_curso as h', 'curso.idCur', '=', 'h.idCur')
                        ->where(function ($query) use ($fecha_inicio, $fecha_fin) {
                            $query->whereBetween('curso.fecInCur', [$fecha_inicio, $fecha_fin])
                            ->orWhere(function ($query) use ($fecha_inicio, $fecha_fin) {
                                $query->whereBetween('curso.fecFinCur', [$fecha_inicio, $fecha_fin]);
                            })
                            ->orWhere(function ($query) use ($fecha_inicio, $fecha_fin) {
                                $query->where('curso.fecInCur', '<=', $fecha_inicio)
                                    ->where('curso.fecFinCur', '>=', $fecha_fin);
                            })->get();
                        })
                        ->where(function ($query) use ($horario) {
                            $query->whereBetween('horIn', [$horario[0]['horIn'], $horario[0]['horFin']])
                            ->orWhereRaw('horIn <= ? and horFin >= ?', [$horario[0]['horIn'], $horario[0]['horFin']])
                            ->orWhereRaw('horFin between ? and ?', [$horario[0]['horIn'], $horario[0]['horFin']]);
                        })
                        ->where('idSala', '=', $sala)
                        ->get();
        return $cursos;
    }

    /**
     * Guarda un curso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->validarDatos($request);
        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $request->curso['fecInCur']);
        $fecha_fin = Carbon::createFromFormat('Y-m-d', $request->curso['fecFinCur']);
        $horario = $request->curso['horarioscurso'];
        $sala = $request->curso['idSala'];
        $cursos = $this->cursos_registrados($fecha_inicio, $fecha_fin, $horario, $sala);
        if(count($cursos) == 0){
            try {
                $durCur = $fecha_inicio->diff($fecha_fin);
                $curso = new Curso();
                $curso->nomCur = $request->curso['nomCur'];
                $curso->fecInCur = $fecha_inicio->format('Y-m-d');
                $curso->fecFinCur = $fecha_fin->format('Y-m-d');
                $curso->reqCur = $request->curso['reqCur'];
                $curso->durCur = $durCur->days;
                $curso->instructor = $request->curso['instructor'];
                $curso->estado = 1;
                $curso->cupCur = $request->curso['cupCur'];
                $curso->idSala = $sala;
                $curso->save();
                $idCurso = $curso->idCur;
                $this->agregarHorarioCurso($horario, $idCurso);
                return [
                    'code' => 1,
                    'mensaje' => 'Ha sido guardado el curso'];
            } catch (exception $e) {
                return $e->getMessage();
            }
        }else{
            return [
                'code' => 2,
                'mensaje' => "Ya hay un curso registrado"];
        }
    }

    /**
     * Actualiza un curso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->validarDatos($request);
        $fecha_inicio = Carbon::createFromFormat('Y-m-d', $request->curso['fecInCur']);
        $fecha_fin = Carbon::createFromFormat('Y-m-d', $request->curso['fecFinCur']);
        $durCur = $fecha_inicio->diffInDays($fecha_fin);
        $horario = $request->curso['horarioscurso'];
        $sala = $request->curso['idSala'];
        $cursos = $this->cursos_registrados($fecha_inicio, $fecha_fin, $horario, $sala);
        if(count($cursos) == 0){
            try {
                $durCur = $fecha_inicio->diff($fecha_fin);
                $curso = Curso::findOrFail($request->curso['idCur']);
                $curso->fecInCur = $fecha_inicio;
                $curso->fecFinCur = $fecha_fin;
                $curso->durCur = $durCur->days;
                $curso->estado = 1;
                $curso->save();
                $this->actualizarHorarioCurso($horario);
                return [
                    'code' => 1,
                    'mensaje' => 'Ha sido actualizado el curso'];
            } catch (exception $e) {
                return $e->getMessage();
            }
        }else{
            return [
                'code' => 2,
                'mensaje' => "Ya hay un curso registrado"];
        }
    }

    public function getDataCurso(Request $request, $idCurso){
        if(!$request->ajax()) return redirect('/');
        $curso = Curso::find($idCurso);
        $horarios = $curso->horarioscurso;
        return $curso;
    }

    /**
     * Agregar horario(s) a un curso
     *¿
     * @param array $horarios;
     * @param int $idCurso;
     */
    public function agregarHorarioCurso($horarios, $idCurso){
        try {
            foreach ($horarios as $horario) {
                $horaFinUnix = strtotime($horario["horFin"]);
                $horariocurso = new HorarioCurso();
                $horariocurso->idCur = $idCurso;
                $horariocurso->horIn = $horario["horIn"];
                $horariocurso->horFin = date('H:i:s', $horaFinUnix - 1);
                $horariocurso->save();
            }
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Actualizar horario(s) a un curso
     *¿
     * @param array $horarios;
     */
    public function actualizarHorarioCurso($horario){
        try {
                $horaFinUnix = strtotime($horario[0]["horFin"]);
                $horariocurso = HorarioCurso::findOrFail($horario[0]['idHor']);
                $horariocurso->horIn = $horario[0]["horIn"];
                $horariocurso->horFin = date('H:i:s', $horaFinUnix - 1);
                $horariocurso->save();
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Deshabilita el curso
     *¿
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try {
            $curso = Curso::findOrFail($request->idCur);
            $curso->estado = 0;
            $curso->save();
            return [
                'code' => 1,
                'mensaje' => 'Ha sido eliminado el curso'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }
}
