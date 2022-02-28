<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\HorarioCurso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * Lista los cursos activos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');   
        $cursos = Curso::select('curso.idCur', 'curso.nomCur', 'curso.fecInCur', 'curso.fecFinCur', 'curso.reqCur')
                        ->orderBy('nomCur', 'ASC')->where('curso.estado', '=', '1')->paginate(10);
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

    public function catalogoCurso(Request $request){
        if(!$request->ajax()) return redirect('/');   
        $cursos = Curso::select('curso.idCur', 'curso.nomCur')
                        ->orderBy('nomCur', 'ASC')->where('curso.estado', '=', '1')->get();
        return ['cursos' => $cursos];
    }

    /**
     * Valida los datos de curso.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function validarDatos($curso) {
        $curso->validate([
            'nomCur' => 'required|string|max:200|unique:curso',
            'fecInCur' => 'required|date',
            'fecFinCur' => 'required|date',
            'reqCur' => 'required|string|max:100',
            'cupCur' => 'required|int|max:15',
            'idSala' => 'required|int',
            'horarios' => 'required|array|min:1'
        ]);
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
        $this->validarDatos($request->curso);
        $fecha_inicio = $request->curso['fecInCur'];
        $fecha_fin = $request->curso['fecFinCur'];
        $horario = $request->curso['horarios'];
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
                            })
                            ->orWhere(function ($query) use ($fecha_inicio, $fecha_fin) {
                                $query->where('curso.fecInCur', '<=', $fecha_inicio)
                                    ->where('curso.fecFinCur', '<=', $fecha_fin);
                            })->get();
                        })
                        ->where(function ($query) use ($request) {
                            $query->whereBetween('horIn', [$horario[0]['horIn'], $horario[0]['horFin']])
                            ->orWhereRaw('horIn <= ? and horFin >= ?', [$horario[0]['horIn'], $horario[0]['horFin']])
                            ->orWhereRaw('horFin between ? and ?', [$horario[0]['horIn'], $horario[0]['horFin']]);
                        })
                        ->where('idSala', '=', $request->idSala)
                        ->get();
        if(count($cursos) == 0){
            try {
                $durCur = $fecha_inicio->diff($fecha_fin);
                $curso = new Curso();
                $curso->nomCur = $request->curso['nomCur'];
                $curso->fecInCur = $fecha_inicio;
                $curso->fecFinCur = $fecha_fin;
                $curso->reqCur = $request->curso['reqCur'];
                $curso->durCur = $durCur->days;
                $curso->durCur = $request->curso['instructor'];
                $curso->estado = 1;
                $curso->cupCur = $request->curso['cupCur'];
                $curso->idSala = $request->curso['idSala'];
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
     * Deshabilita el curso
     *¿
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try {
            $curso = Curso::findOrFail($request->id);
            $curso->estado = 0;
            $curso->save();
            return ['mensaje' => 'Ha sido eliminado el curso'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }
}
