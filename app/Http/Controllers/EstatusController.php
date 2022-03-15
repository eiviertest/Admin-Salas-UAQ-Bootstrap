<?php

namespace App\Http\Controllers;

use App\Models\Estatus;
use Illuminate\Http\Request;

class EstatusController extends Controller
{
    /**
     * Lista los estatus con paginacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $estados = Estatus::select('idEst as ide', 'nomEst as nombre')->orderBy('nomEst', 'ASC')->paginate(10);
        return [
            'pagination' => [
                'total' => $estados->total(),
                'current_page' => $estados->currentPage(),
                'per_page' => $estados->perPage(),
                'last_page' => $estados->lastPage(),
                'from' => $estados->firstItem(),
                'to' => $estados->lastItem()
            ],
            'estados' => $estados];
    }

    /**
     * Almacena un estatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->validarDatos($request);
        try {
            $estatus = new Estatus();
            $estatus->nomEst = $request->nomEst;
            $estatus->save();
            return ['mensaje' => 'Ha sido guardado el estado'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Actualiza un estatus
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->validarDatos($request);
        try {
            $estatus = Estatus::findOrFail($request->id);
            $estatus->nomEst = $request->nomEst;
            $estatus->save();
            return ['mensaje' => 'Ha sido actualizado el estado'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Valida los datos enviados
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function validarDatos(Request $request) {
        $request->validate([
            'nomEst' => 'required|string|max:200|unique:estatus',
        ]);
    }

    /**
     * Elimina un estatus
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try {
            $estatus = Estatus::findOrFail($request->id);
            $estatus->delete();
            return ['mensaje' => 'Ha sido eliminado el estado'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }
}
