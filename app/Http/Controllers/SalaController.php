<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    /**
     * Lista las salas con paginacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $salas = Sala::select('idSala as ide', 'nomSala as nombre')->orderBy('nomSala', 'ASC')->paginate(10);
        return [
            'pagination' => [
                'total' => $salas->total(),
                'current_page' => $salas->currentPage(),
                'per_page' => $salas->perPage(),
                'last_page' => $salas->lastPage(),
                'from' => $salas->firstItem(),
                'to' => $salas->lastItem()
            ],
            'salas' => $salas];
    }

    /**
     * Lista las salas sin paginacion
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function catalogoSalas(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $salas = Sala::select('idSala', 'nomSala')->orderBy('nomSala', 'ASC')->get();
        return ['salas' => $salas];
    }

    /**
     * Almacena una sala
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->validarDatos($request);
        try {
            $sala = new Sala();
            $sala->nomSala = $request->nomSala;
            $sala->save();
            return ['mensaje' => 'Ha sido guardada la sala'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Valida la informacion enviada
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function validarDatos(Request $request) {
        $request->validate([
            'nomSala' => 'required|string|max:200|unique:sala',
        ]);
    }

    /**
     * Actualiza una sala
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $this->validarDatos($request);
        try {
            $sala = Sala::findOrFail($request->id);
            $sala->nomSala = $request->nomSala;
            $sala->save();
            return ['mensaje' => 'Ha sido actualizada la sala'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Elimina una sala
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try {
            $sala = Sala::findOrFail($request->id);
            $sala->delete();
            return ['mensaje' => 'Ha sido eliminada la sala'];
        } catch (exception $e) {
            return $e->getMessage();
        }
    }
}
