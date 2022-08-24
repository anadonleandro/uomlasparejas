<?php

namespace App\Http\Controllers;

use App\Models\CPostal;
use Illuminate\Http\Request;
use Auth;
use DB;

class CodigoPostal extends Controller
{
	$resultados = null;
    $error = null;
	
    public function indexCPostal()
    {
        return view("cpostales/index");
    }

    public function create()
    {
        return view('cpostales.create');
    }

    public function store(Request $request)
    {
        try {
            $cpostal = new CPostal;

            $cpostal->cpostal        = $request->input('cpostal'));
            $cpostal->nombre         = strtoupper($request->input('nombre'));
            $cpostal->save();

            return response()->json(['resultados' => 'ok', 'mensaje' => $cpostal->id]);
		} catch (\Throwable $th) {
            $error = $th->getMessage();
            return response()->json(['resultados' => 'error', 'error' => $error]);
        }
    }

    public function edit(Request $request)
    {
        $cpostal = CPostal::findOrFail($request->id);

        return view("cpostales.edit", compact('cpostal'));
    }

    public function update(Request $request)
    {
        $error = null;
        try {

            //GUARDAMOS EN UNA VARIABLE AUXILIAR EL REGISTRO
            $cpostalAux = CPostal::findOrFail($request->id);
            //INICIO VALIDACION FECHAS SOLAPADAS
            
            $cpostal = CPostal::findOrFail($request->id);

            $cpostal->cpostal        = strtoupper($request->input('cpostal')); // este campo no se deberia poder modificar.
            $cpostal->nombre        = strtoupper($request->input('nombre'));
			
            if ($cpostalAux != $cpostal) {
                $cpostales->update();

                return response()->json(['resultados' => 'ok', 'mensaje' => $cpostal->nombre]);
            } else {
                return response()->json(['resultados' => 'error']);
            }
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            dd($error);
        }
    }

    public function show(Request $request)
    {
        $cpostal = CPostal::findOrFail($request->input('id'));

        return view("cpostales/show", compact('cpostal'));
    }
}
