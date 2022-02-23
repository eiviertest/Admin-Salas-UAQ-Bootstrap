<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Lista todas las areas, dependencias registradoas
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $areas = Area::select('idArea as ide', 'nomArea as nombre')->orderBy('nomArea', 'ASC')->paginate(10);
        return ['areas' => $areas];
    }

    public function catalogo_area(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $areas = Area::select('idArea', 'nomArea')->orderBy('nomArea', 'ASC')->get();
        return ['areas' => $areas];
    }

    /**
     * Almacena una area/dependencia
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if(!$request->ajax()) return redirect('/');
        $this->validarDatos($request);
        try {
            $area = new Area();
            $area->nomArea = $request->nomArea;
            $area->save();
            return ['mensaje' => 'Ha sido guardada el área'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Actualiza una area/dependencia
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->validarDatos($request);
        try {
            $area = Area::findOrFail($request->id);
            $area->nomArea = $request->nomArea;
            $area->save();
            return ['mensaje' => 'Ha sido actualizada el área'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    public function validarDatos(Request $request) {
        $request->validate([
            'nomArea' => 'required|string|max:200|unique:area',
        ]);
    }

    /**
     * Elimina una area/dependencia
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try {
            $area = Area::findOrFail($request->id);
            $area->delete();
            return ['mensaje' => 'Ha sido eliminada el área'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }
}
