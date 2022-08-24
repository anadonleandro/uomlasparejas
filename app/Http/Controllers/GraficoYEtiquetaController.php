<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Titular;
use Illuminate\Http\Request;

/**
 * Controlador encargado del envio de informacion para graficos y
 * las cuatro etiquetas del HOME
 *@method Chaleco[] getChalecos(Request $value)
 
 */
class GraficoYEtiquetaController extends Controller
{
    public function getDataEtiquetaTotalEmpresas()
    { // TOTAL GENERAL DE  EMPRESAS
        try {
            $totalEmpresas = Empresa::where('estado', 0) // 0 activa
                ->count();

            return  response()->json(compact('totalEmpresas'));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getCode() . " " . $th->getMessage()]);
        }
    }

    public function getDataEtiquetaTitulares()
    { // TITULARES
        try {
            $total_titulares = Titular::count();

            return  response()->json(compact('total_titulares'));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getCode() . " " . $th->getMessage()]);
        }
    }
}
