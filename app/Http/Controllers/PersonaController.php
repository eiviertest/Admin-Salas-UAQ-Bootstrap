<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    /**
     * Lista las personas sin paginacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function catalogoPersonas(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personas = Persona::select('idPer', DB::raw('CONCAT(nomPer, " ", apePatPer, " ", IFNULL(apeMatPer, "")) as nombrePer'))->orderBy('nomPer', 'ASC')->get();
        return ['personas' => $personas];
    }
}
