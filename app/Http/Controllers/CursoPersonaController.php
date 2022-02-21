<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\CursoPersona;
use App\Models\Curso;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CursoPersonaController extends Controller
{   
    /**
     * Descargar los cursos por semestre
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function cursos_impartidos(Request $request){
        if(!$request->ajax()) return redirect('/');
        $fecha_actual = Carbon::now()->format('m-d');
        $semestre = "";
        $total_cursos = 0;
        if($fecha_actual < '07-01') { 
            //Primer semestre
            $semestre = "Primer semestre";
            $inicio_anio = "01-01";
            $medio_anio = "06-30";
            $cursos = $this->cursos_impartidos_fecha($inicio_anio, $medio_anio);
        }else{
            //Segundo semestre
            $semestre = "Segundo semestre";
            $medio_anio = "07-01";
            $fin_anio = "12-31";
            $cursos = $this->cursos_impartidos_fecha($medio_anio, $fin_anio);
        }
        $pdf = PDF::loadView('reportes.cursos_impartidos', ['cursos' => $cursos, 'semestre'=>$semestre]);
        return $pdf->download('cursos_impartidos.pdf');
    }

    /**
     * Descargar los cursos por semestre
     *
     * @param date fecha_inicio fecha_fin
     * @return array Cursos
     */
    public function cursos_impartidos_fecha($fecha_inicio, $fecha_fin){
        $cursos = Curso::select('curso.nomCur', 'curso.fecInCur', 'curso.fecFinCur', 'cupCur', 's.nomSala')
                        ->join('sala as s', 's.idSala', '=', 'curso.idSala')
                        ->whereRaw('DATE_FORMAT(curso.fecInCur, "%m-%d") >= ? and DATE_FORMAT(curso.fecFinCur, "%m-%d") <= ?', [$fecha_inicio, $fecha_fin])
                        ->get();
        return $cursos;
    }

    /**
     * Descargar las personas por curso
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function concentrado_curso(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idCurso = $request->idCur;
        $personas = CursoPersona::select(DB::raw('CONCAT(p.nomPer, " ", p.apeMatPer, " ", p.apePatPer) as nombre'), 'a.nomArea')
                    ->join('persona as p', 'curso_persona.idPer', '=', 'p.idPer')
                    ->join('area as a', 'a.idArea', '=', 'p.idArea')
                    ->where('curso_persona.idCur', '=', $idCurso)
                    ->where('curso_persona.estatus', '=', 'Aceptado')
                    ->get();
        $datos_curso = Curso::select('nomCur', 'fecInCur', 'fecFinCur', 'nomSala')
                            ->join('sala as s', 's.idSala', '=', 'curso.idSala')
                            ->where('idCur', '=', $idCurso)
                            ->first();
        $pdf = PDF::loadView('reportes.concentrado_curso', ['personas'=>$personas, 'datos_curso' => $datos_curso]);
        return $pdf->download('concentrado_curso.pdf');
    }

    /**
     * Enviar solicitud para enrolarse a un curso
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function enrolarse_curso(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idPersona = $this->getIdPersona(Auth::user()->id);
        $verificar = CursoPersona::select('idPer')->where('idPer', '=', $idPersona->idPer)->where('idCur', '=', $request->idCur)->first();
        if(empty($verificar)) {
            //Registrar
            try{
                $idPrimary = $idPersona->idPer.$request->idCur;
                $enrolarse = new CursoPersona();
                $enrolarse->idPeridCur = $idPrimary;
                $enrolarse->idCur = $request->idCur;
                $enrolarse->idPer = $idPersona->idPer;
                $enrolarse->estatus = 'En proceso';
                $enrolarse->save();
                return ['mensaje' => 'Usted se ha enrolado'];
            }catch(exception $e){
                return $e->getMessage();
            }
        }else{
            return ['mensaje' => 'Usted ya se enrolo a este curso'];
        }   
    }

    /**
     * Aceptar persona al curso
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function aceptar_persona_curso(Request $request){
        if(!$request->ajax()) return redirect('/');
        $personas_enroladas = CursoPersona::selectRaw('count(*) as total')->where('idCur', '=', $request->idCur)->where('estatus', '=', 'Aceptado')->get();
        $cupo_maximo = Curso::select('cupCur')->where('idCur', '=', $request->idCur)->first();
        if($personas_enroladas[0]->total >= $cupo_maximo->cupCur) {
            //Ya alcanzo el limite
            return ['mensaje' => 'El cupo del curso fue alcanzado'];
        }else{
            //Aceptar
            try {
                $curso_persona = CursoPersona::findOrFail($request->idPer.$request->idCur);
                $curso_persona->estatus = 'Aceptado';
                $curso_persona->save();
                return ['mensaje' => 'El usuario ha sido aceptado'];
            } catch (exception $e) {
                return $e->getMessage();
            }
        }
    }

    /**
     * Rechazar persona al curso
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rechazar_persona_curso(Request $request){
        if(!$request->ajax()) return redirect('/');
        try {
            $curso_persona = CursoPersona::findOrFail($request->idPer.$request->idCur);
            $curso_persona->estatus = 'Rechazado';
            $curso_persona->save();
            return ['mensaje' => 'El usuario ha sido rechazado'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    
    /**
     * Lista de solicitudes para enrolarse
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function lista_curso_persona(Request $request){
        if(!$request->ajax()) return redirect('/');
        $lista_curso_persona = CursoPersona::select('p.idPer', DB::raw('CONCAT(p.nomPer, " ", p.apeMatPer, " ", p.apePatPer) as nombre'), 'c.nomCur', 'curso_persona.estatus', 'c.idCur')
                        ->join('persona as p', 'p.idPer', '=', 'curso_persona.idPer')
                        ->join('curso as c', 'c.idCur', '=', 'curso_persona.idCur')
                        ->orderBy('curso_persona.estatus', 'ASC')
                        ->get();
        return $lista_curso_persona;
    }
}
