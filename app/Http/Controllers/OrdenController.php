<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ImpresionController;
use Illuminate\Http\Request;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\Titular;
use App\Models\Familiar;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Controllers\Constantes\Constants as Constantes;

class OrdenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexOrden()
    {
        return view("orden.index");
    }

    public function getOrdenes()
    { // muestra las ultimas 20 ordenes generadas
        $resultados = Orden::latest()->take(20)
            ->orderBy('created_at', 'DESC')
            ->get();

        foreach ($resultados as $resu) {
            switch ($resu->estado) {
                case 1:
                    $resu->estado = "ACTIVA";
                    break;
                case 2:
                    $resu->estado = "PASIVA";
                    break;
            }

            switch ($resu->tipo_beneficiario) {
                case 0:
                    $nombre = DB::table('ordenes')
                        ->join('titulares', 'ordenes.id_titular', '=', 'titulares.id_titular')
                        ->select('titulares.nom_titular')
                        ->where('titulares.id_titular', $resu->id_titular)
                        ->first();
                    $resu->id_beneficiario = $nombre->nom_titular;
                    $resu->tipo_beneficiario = "TITULAR";
                    break;
                case 1:
                    $nombre = DB::table('ordenes')
                        ->join('familiares', 'ordenes.id_beneficiario', '=', 'familiares.id_familiar')
                        ->select('familiares.nom_familiar')
                        ->where('familiares.id_familiar', $resu->id_beneficiario)
                        ->first();

                    $resu->id_beneficiario = $nombre->nom_familiar;
                    $resu->tipo_beneficiario = "FAMILIAR";
                    break;
            }
        }

        return  response()->json(['resultados' => $resultados]);
    }

    public function create()
    {
        $tiposPrestaciones = DB::table('tipos_prestaciones')
            ->get();

        $practicasPmo = DB::table('practicaspmo')
            ->select('id', 'codigo', 'denominacion')
            ->orderBy('codigo')
            ->get();

        return view("orden.create", compact('tiposPrestaciones', 'practicasPmo'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $orden = new Orden;
            $orden->id_titular            = $request->id_titular;
            $request->tipoBeneficiario == 0
                ? $orden->id_beneficiario = $request->id_titular
                : $orden->id_beneficiario = $request->id_familiar;
            $orden->tipo_beneficiario     = $request->tipoBeneficiario;
            $orden->solicitante           = strtoupper($request->solicitante);
            $orden->tipo_estudio          = $request->tipo_estudio;
            $orden->diagnostico           = strtoupper($request->diagnostico);
            $orden->derivacion            = strtoupper($request->derivacion);
            $orden->obs                   = strtoupper($request->obs);
            $orden->fecha_estudio         = $request->fecha_estudio;
            $orden->fecha_realizacion     = $request->fecha_realizacion;
            $orden->importe_total         = $request->total_pagar;
            $orden->importe_bonificacion  = $request->bonificacion;
            $orden->motivo_bonificacion   = strtoupper($request->motivo_bonificacion);
            $orden->estado                = 1; //ACTIVA
            $orden->id_opr                = Auth::user()->id;
            $orden->save();

            $id_pmo = $request->id_pmo;
            $cantidad = $request->cantidad;
            $subtotal = $request->subtotal;
            $cont = 0;

            while ($cont < count($id_pmo)) {
                $ordenDetalle           = new OrdenDetalle();
                $ordenDetalle->id_orden = $orden->id;
                $ordenDetalle->id_pmo   = $id_pmo[$cont];
                $ordenDetalle->cantidad = $cantidad[$cont];
                // ver importe de cada pmo ///////////
                $ordenDetalle->importe  = $subtotal[$cont];
                $ordenDetalle->save();
                $cont++;
            }

            DB::commit();

            return  response()->json(['resultados' => "ok"]);
            //return redirect()->route('indexOrden');
        } catch (\Throwable $th) {
            DB::rollback();
            $error = $th->getMessage();
            return  response()->json(['resultados' => "error", 'error' => $error]);
        }
    }

    public function buscarBeneficiario(Request $request)
    {
        try {
            switch ($request->tipo) {
                case 0: // es tipo TITULAR
                    $beneficiario = DB::table('titulares')
                        ->join('documento_tipos', 'titulares.tp_doc', '=', 'documento_tipos.id')
                        ->select(
                            'titulares.nom_titular',
                            'titulares.nro_doc',
                            'documento_tipos.nom_tipo',
                            'titulares.sexo',
                            'titulares.id_titular'
                        )
                        ->where('nro_doc', $request->dni)
                        ->first();
                    break;
                case 1:  // es tipo FAMILIAR
                    $beneficiario = DB::table('familiares')
                        ->join('titulares', 'titulares.nro_doc', '=', 'familiares.nro_doc_tit')
                        ->join('documento_tipos', 'familiares.tp_doc', '=', 'documento_tipos.id')
                        ->join('vinculos', 'vinculos.id', '=', 'familiares.vinculo')
                        ->select(
                            'titulares.nom_titular',
                            'familiares.nom_familiar',
                            'familiares.sexo',
                            'familiares.nro_doc',
                            'documento_tipos.nom_tipo',
                            'vinculos.nom_vinculo',
                            'familiares.id_familiar',
                            'titulares.id_titular'
                        )
                        ->where('familiares.nro_doc', $request->dni)
                        ->first();
                    break;
            }

            return  response()->json(['beneficiario' => $beneficiario]);
        } catch (\Throwable $th) {
            return  response()->json(['error' => $th->getMessage()]);
            // dd($th->getMessage());
        }
    }

    public function show(Request $request)
    {
        $orden = Orden::findOrFail($request->id);
        //dd($orden);
        $tipoEstudio = DB::table('tipos_prestaciones')
            ->where('id', $orden->tipo_estudio)
            ->first();

        switch ($orden->estado) {
            case 1:
                $orden->estado = "ACTIVA";
                break;
            case 2:
                $orden->estado = "PASIVA";
                break;
        }

        switch ($orden->tipo_beneficiario) {
            case 0: // es titular
                $titular = DB::table('ordenes')
                    ->join('titulares', 'ordenes.id_titular', '=', 'titulares.id_titular')
                    ->join('documento_tipos', 'titulares.tp_doc', '=', 'documento_tipos.id')
                    ->select('titulares.nom_titular', 'documento_tipos.nom_tipo', 'titulares.nro_doc', 'titulares.fec_nacimiento')
                    ->where('titulares.id_titular', $orden->id_titular)
                    ->first();

                $familiar = "";
                $edadFamiliar = "";
                // CALCULO DE FECHA DE NACIMIENTO
                if ($titular->fec_nacimiento != '1900-01-01') {
                    $edadTitular = Carbon::parse($titular->fec_nacimiento)->diffInYears(now());
                } else {
                    $edadTitular = "SIN DATOS";
                }
                $orden->fecha_estudio = Carbon::parse($orden->fecha_estudio)->format('d-m-Y'); // formatea fecha
                $orden->vencimiento = $orden->created_at->addDays(Constantes::DIAS_VENCIMIENTO_ORDEN);

                break;
            case 1: // es familiar
                $familiar = DB::table('ordenes')
                    ->join('familiares', 'ordenes.id_beneficiario', '=', 'familiares.id_familiar')
                    ->join('documento_tipos', 'familiares.tp_doc', '=', 'documento_tipos.id')
                    ->select('familiares.nom_familiar', 'documento_tipos.nom_tipo', 'familiares.nro_doc', 'familiares.fec_nacimiento')
                    ->where('familiares.id_familiar', $orden->id_beneficiario)
                    ->first();
                $titular = DB::table('ordenes')
                    ->join('titulares', 'ordenes.id_titular', '=', 'titulares.id_titular')
                    ->join('documento_tipos', 'titulares.tp_doc', '=',  'documento_tipos.id')
                    ->select('titulares.nom_titular', 'documento_tipos.nom_tipo', 'titulares.nro_doc', 'titulares.fec_nacimiento')
                    ->where('titulares.id_titular', $orden->id_titular)
                    ->first();
                // CALCULO DE FECHA DE NACIMIENTO
                if ($titular->fec_nacimiento != '1900-01-01') {
                    $edadTitular = Carbon::parse($titular->fec_nacimiento)->diffInYears(now());
                } else {
                    $edadTitular = "SIN DATOS";
                }
                if ($familiar->fec_nacimiento != '1900-01-01') {
                    $edadFamiliar = Carbon::parse($familiar->fec_nacimiento)->diffInYears(now());
                } else {
                    $edadFamiliar = "SIN DATOS";
                }
                $orden->fecha_estudio = Carbon::parse($orden->fecha_estudio)->format('d-m-Y');  // formatea fecha
                $orden->vencimiento = $orden->created_at->addDays(Constantes::DIAS_VENCIMIENTO_ORDEN);
                break;
        }

        return view("orden/show", compact('orden', 'tipoEstudio', 'titular', 'familiar', 'edadTitular', 'edadFamiliar'));
    }

    public function edit(Request $request)
    {
        $orden = Orden::findOrFail($request->id);

        return view("orden.edit", compact('orden'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $orden = Orden::findOrFail($request->id);
            $orden->estado = $request->estado;
            $orden->obs_anulo = strtoupper($request->obs_anulo);
            $orden->id_opr_anulo = Auth::user()->id;
            $orden->update();

            DB::commit();
            return  response()->json(['resultados' => "ok"]);
        } catch (\Throwable $th) {
            DB::rollback();
            $error = $th->getMessage();
            return  response()->json(['resultados' => "error", 'error' => $error]);
        }
    }

    public function getPrecioPmo(Request $request)
    {   // calcula el precio final de la prestacion:
        // multiplicando el valor fijado en tabla del NBU por la cantidad que tiene cada practica que se recibe
        try {
            $id = explode("_", $request->id)[0];
            // toma el id de concatenado separado por guion bajo q se recibe (id _ codigoPmo)

            $getCantidadNbu = DB::table('practicaspmo')
                // obtiene cantidad de NBU de la practica
                ->select('valor_nbu')
                ->where('id', $id)
                ->first();

            $getPrecio = DB::table('valor_nbu') // obtiene el valor establecido del NBU
                ->select('valor')
                ->first();

            $precioFinal =  intval($getCantidadNbu->valor_nbu) * intval($getPrecio->valor);
            // se pasan a ENTERO porque se reciben como TEXTOS
            // ver si se necesita en decimal 'float()' ???????

            return response()->json(['precioFinal' => $precioFinal]);
        } catch (\Throwable $th) {
            // ver capturar mensaje de error
            dd($th->getMessage());
        }
    }
}
