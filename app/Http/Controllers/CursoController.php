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
        return ['cursos' => $cursos];
    }

    /**
     * Valida los datos de curso.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function validarDatos(Request $request) {
        $request->validate([
            'nomCur' => 'required|string|max:200|unique:curso',
            'fecInCur' => 'required|date',
            'fecFinCur' => 'required|date',
            'reqCur' => 'required|string|max:100',
            'durCur' => 'required|int|max:40',
            'cupCur' => 'required|int|max:10',
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
        $this->validarDatos($request);
        $cursos = Curso::select('curso.nomCur')
                        ->join('horario_curso as h', 'curso.idCur', '=', 'h.idCur')
                        ->whereBetween('curso.fecInCur', [$request->fecInCur, $request->fecFinCur])
                        ->whereBetween('horIn', [$request->horarios[0]['horIn'], $request->horarios[0]['horFin']])
                        ->where('idSala', '=', $request->idSala)
                        ->get();
        if(empty($cursos)){
            try {
                $curso = new Curso();
                $curso->nomCur = $request->nomCur;
                $curso->fecInCur = $request->fecInCur;
                $curso->fecFinCur = $request->fecFinCur;
                $curso->reqCur = $request->reqCur;
                $curso->durCur = $request->durCur;
                $curso->estado = 1;
                $curso->cupCur = $request->cupCur;
                $curso->idSala = $request->idSala;
                $curso->save();
                $idCurso = $curso->idCur;
                $this->agregarHorarioCurso($request->horarios, $idCurso);
                return ['mensaje' => 'Ha sido guardado el curso'];
            } catch (exception $e) {
                return $e->getMessage();
            }
        }else{
            return ['mensaje' => "Ya hay un curso registrado"];
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
                $horariocurso = new HorarioCurso();
                $horariocurso->idCur = $idCurso;
                $horariocurso->horIn = $horario["horIn"];
                $horariocurso->horFin = $horario["horFin"];
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
