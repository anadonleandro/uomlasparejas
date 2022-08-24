<?php

namespace App\Http\Controllers;

use DB;
use App\Models\ExcelPagos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Auth;

class ExcelArchivoController extends Controller
{ // guarda nombre a archivo procesado en tabla
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function guardarNombreArchivo($nombre, $cantidad, $generada, $extras, $noGenerada, $convenio)
    {
        try {
            $guardaNombre = new ExcelPagos;
            $guardaNombre->nombre_archivo = $nombre;
            $guardaNombre->fecha_proceso = Carbon::now()->format('Y-m-d');
            $guardaNombre->id_usr = Auth::user()->id;
            $guardaNombre->cantidad = $cantidad;
            $guardaNombre->generada = $generada;
            $guardaNombre->extras = $extras;
            $guardaNombre->no_generada = $noGenerada;
            $guardaNombre->convenio = $convenio;

            $guardaNombre->save();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function indexArchivos()
    {
        return view('consultas.archivosExcel');
    }

    public function getArchivos()
    {
        try {
            $resultados = ExcelPagos::orderBy('id', 'DESC')
                ->get();

            foreach ($resultados as $resultado) {
                $usuario = DB::table('users')->where('id', $resultado->id_usr)
                    ->first(); // BUSCA NOMBRE DE USUARIO
                $resultado->id_usr = $usuario->name;
                // FORMATEA FECHA HORA
                $resultado->fecha_proceso = $resultado->created_at->format('d/m/Y - H:i');
            }

            return response()->json(['resultados' => $resultados]);
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            return  response()->json(['resultado' => "error", 'error' => $error]);
        }
    }
}
