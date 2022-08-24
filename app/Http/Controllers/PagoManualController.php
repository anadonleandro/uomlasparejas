<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Deuda;
use Auth;
use DB;

class PagoManualController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pagoManualDeuda()
    {
        $empresas = Empresa::get();
        return view("pagomanual.create", compact('empresas'));
    }


    public function getDeudaManual()
    {  //busca las deudas manuales activas
        try {
            $resultados = Deuda::where('estado', 0) // activa
                ->where('imputacion_manual', 1) // deuda manual
                ->where('estado', '!=',2) //
                ->orderBy('id_deuda', 'DESC')
                ->get();

            foreach ($resultados as $deuda) {

                switch ($deuda->tipo_cuenta) {
                        // carga el nombre del concepto para vista
                    case 1:
                        $deuda->concepto = "OBRA SOCIAL";
                        break;
                    case 2:
                        $deuda->concepto = "2,5% SINDICAL";
                        break;
                    case 3:
                        $deuda->concepto = "SEGURO";
                        break;
                    case 4:
                        $deuda->concepto = "2% SINDICAL";
                        break;
                    case 5:
                        $deuda->concepto = "ACUERDO DE PAGO";
                        break;
                }
                $nombreUsuario = DB::table('users')
                    ->select('name')
                    ->where("id", $deuda->id_opr)
                    ->first();

                $deuda->user = $nombreUsuario->name; // asigna a propiedad inventada

                $nombreEmpresa = Empresa::select('nom_empresa')
                    ->where("cod_empresa", $deuda->cod_empresa)
                    ->first();

                $deuda->empresa = $nombreEmpresa->nom_empresa . " - " . $deuda->cod_empresa; // asigna a propiedad inventada
            }
            return  response()->json(['resultados' => $resultados]);
        } catch (\Throwable $th) {
            return  response()->json(['resultados' => "error", 'error' => $th->getMessage()]);
        }
    }

    public function indexPagoManualDeuda()
    {
        return view("pagomanual.index");
    }

    public function store(Request $request)
    { // graba en BD utilizando mismo metodo que el archivo excel
        try {
            $datos = new Request;

            $datos->tipo_cuenta             = $request->tipo_cuenta;
            $datos->cod_empresa             = $request->cod_empresa;
            $datos->fecha_deposito          = $request->fecha_deposito;
            $datos->periodo                 = $request->periodo;
            if ($request->cant_afil_titulares) { // si tiene valor, lo asigna
                $datos->cant_afil_titulares = $request->cant_afil_titulares;
            } else {
                $datos->cant_afil_titulares = 0;
            }
            $datos->cant_afil_titulares     = $request->cant_afil_titulares;
            $datos->ipte_total_remuneracion = $request->ipte_total_remuneracion;
            $datos->ipte_depositado         = $request->ipte_depositado;
            // propiedades agregadas para control posterior en otro controller
            $datos->pago_manual             = true;
            $datos->cod_seccional           = 181;
            if ($request->nro_acuerdo) { // si tiene valor, lo asigna
                $datos->nro_acuerdo         = $request->nro_acuerdo;
            } else {
                $datos->nro_acuerdo         = 50; // NRO_ACUERDO???? (50)
            }

            if ($request->nro_cuota) { // si tiene valor, lo asigna
                $datos->nro_cuota           = $request->nro_cuota;
            } else { // sino le pone 0
                $datos->nro_cuota           = 0;
            }
            //pruebo copiando los metodos del DeudaController
            $copiaRequest = $datos;
            $datosJson = json_decode(json_encode($copiaRequest), FALSE);
            // convierte en json y luego inserta en array, para mantener
            // formato que utiliza el método del proceso de archivo excel
            $datosProceso = [];
            array_push($datosProceso, $datosJson);
            $datosProceso[0]->imputacion_manual = 1; // 1 - manual

            if (is_null($datosProceso[0]->tipo_cuenta) && is_null($datosProceso[0]->cod_empresa) && is_null($datosProceso[0]->ipte_total_remuneracion)) {
                // si son los tres campos nulos, no hay informacion en archivo excel
                try {
                    // lo unico que hace al recibir informacion nula
                    // es enviar nombre de archivo a tabla excel_pagos
                    $nombreArchivo = $datosProceso[0]->nombre_archivo;
                    $archivo = new ExcelArchivoController; // va a controlador a guardar nombre de archivo
                    $cantidad = $generada = $extras = $noGenerada = $convenio = 0;
                    $archivo->guardarNombreArchivo($nombreArchivo, $cantidad, $generada, $extras, $noGenerada, $convenio);
                    return response()->json(['resultado' => 'ok', 'cantidad' => 0, 'generada' => 0, 'extras' => 0, 'noGenerada' => 0, 'convenio' => 0]);
                } catch (\Throwable $th) {
                    $error = $th->getMessage();
                    return  response()->json(['resultado' => "error", 'error' => $error]);
                }
            } else {
                // PROCESO NORMAL DE CARGA DE EXCEL o DEUDA MANUAL///////////////////////////
                $update = $insert = $insert2 = $insert3 = 0;
                //$this->checkEmpresaInexistente($datosProceso); // chequea existencia de empresa en BD
                try {
                    DB::beginTransaction();
                    foreach ($datosProceso as $dato) { // FORMATEAMOS LA FECHA DE DEPOSITO PARA UTILIZAR EN CONDICION DE BUSQUEDA
                        if (strlen($dato->fecha_deposito) == 8) {
                            // en excel la fecha viene formato AAAAMMDD (8 caract.)
                            // hay q formatearla con guiones, no así para el proceso Deuda Manual
                            $fecDepositoFormat = substr($dato->fecha_deposito, -8, 4) . "-" . substr($dato->fecha_deposito, -4, 2) . "-" . substr($dato->fecha_deposito, -2, 2);
                            $dato->fecha_deposito = $fecDepositoFormat;
                        }

                        if ($dato->nro_cuota == 0 && $dato->periodo !== 0) { //CONTROL SI NO ES CONVENIO
                            //LO BUSCAMOS EN LA TABLA DEUDAS POR EMPRESA+TIPO-CUENTA+PERIODO
                            $deuda = Deuda::where('cod_empresa', $dato->cod_empresa)
                                ->where('tipo_cuenta', $dato->tipo_cuenta)
                                ->where('periodo', $dato->periodo)
                                ->first();
                            if ($deuda) { //SI EXISTE LA DEUDA
                                //SI NO COINCIDE IMPORTE DEPOSITADO, CANTIDAD EMPLEADOS PAGADOS Y FECHA DE PAGO
                                if ($dato->ipte_depositado !== $deuda->ipte_depositado || $dato->cant_afil_titulares !== $deuda->cant_afil_titulares || $dato->fecha_deposito !== $deuda->fecha_acreditacion) {
                                    if ($deuda->ipte_depositado == 0) { //HACER UPDATE SI EL IMPORTE-DEPOSITADO EN DEUDA ES 0
                                        $update++;
                                        $deuda->ipte_depositado         = $dato->ipte_depositado;
                                        $deuda->fecha_acreditacion      = $dato->fecha_deposito;
                                        $deuda->cant_afil_titulares     = $dato->cant_afil_titulares;
                                        $deuda->ipte_total_remuneracion = $dato->ipte_total_remuneracion;
                                        $deuda->nro_acuerdo             = $dato->nro_acuerdo;
                                        $deuda->nro_cuota               = $dato->nro_cuota;
                                        $deuda->estado                  = 0; //PAGADA
                                        $deuda->id_opr                  = Auth::user()->id;
                                        if ($dato->imputacion_manual) {
                                            $deuda->imputacion_manual   = $dato->imputacion_manual;
                                        } else {
                                            $deuda->imputacion_manual   = 0; // cuando es proceso de excel
                                        }

                                        $deuda->update();
                                    } elseif ($deuda->ipte_depositado > 0) {
                                        //HACER INSERT SI IMPORTE-DEPOSITADO EN DUEDA ES > 0 
                                        //YA QUE SERIAN PAGOS EXTRAS
                                        $empresa = Empresa::where('cod_empresa', $dato->cod_empresa)
                                            ->first();
                                        if ($empresa) {
                                            $insert++;
                                            $nuevaDeuda                          = new Deuda;
                                            $nuevaDeuda->cod_seccional           = $dato->cod_seccional;
                                            $nuevaDeuda->id_empresa              = $empresa->id_empresa;
                                            $nuevaDeuda->cod_empresa             = $dato->cod_empresa;
                                            $nuevaDeuda->tipo_cuenta             = $dato->tipo_cuenta;
                                            $nuevaDeuda->fecha_acreditacion      = $dato->fecha_deposito;
                                            $nuevaDeuda->periodo                 = $dato->periodo;
                                            $nuevaDeuda->cant_afil_titulares     = $dato->cant_afil_titulares;
                                            $nuevaDeuda->ipte_total_remuneracion = $dato->ipte_total_remuneracion;
                                            $nuevaDeuda->ipte_depositado         = $dato->ipte_depositado;
                                            $nuevaDeuda->nro_acuerdo             = $dato->nro_acuerdo;
                                            $nuevaDeuda->nro_cuota               = $dato->nro_cuota;
                                            $nuevaDeuda->estado                  = 0; // 0 pagada ????
                                            if ($dato->imputacion_manual) {
                                                $nuevaDeuda->imputacion_manual   = $dato->imputacion_manual;
                                            } else {
                                                $nuevaDeuda->imputacion_manual   = 0; // cuando es proceso de excel
                                            }
                                            $nuevaDeuda->id_opr                  = Auth::user()->id;

                                            $nuevaDeuda->save();
                                        }
                                    }
                                }
                            } else { //SI NO EXISTEN DEUDAS CON ESOS PARAMETROS
                                //CORRESPONDEN A DEUDAS QUE NO SE GENERARON
                                //BUSCO LA EMPRESA, SI EXISTE HAGO EL INSERT
                                $empresa = Empresa::where('cod_empresa', $dato->cod_empresa)
                                    ->first();
                                if ($empresa) {
                                    $insert2++;
                                    $nuevaDeuda2                          = new Deuda;
                                    $nuevaDeuda2->cod_seccional           = $dato->cod_seccional;
                                    $nuevaDeuda2->id_empresa              = $empresa->id_empresa;
                                    $nuevaDeuda2->cod_empresa             = $dato->cod_empresa;
                                    $nuevaDeuda2->tipo_cuenta             = $dato->tipo_cuenta;
                                    $nuevaDeuda2->fecha_acreditacion      = $dato->fecha_deposito;
                                    $nuevaDeuda2->periodo                 = $dato->periodo;
                                    $nuevaDeuda2->cant_afil_titulares     = $dato->cant_afil_titulares;
                                    $nuevaDeuda2->ipte_total_remuneracion = $dato->ipte_total_remuneracion;
                                    $nuevaDeuda2->ipte_depositado         = $dato->ipte_depositado;
                                    $nuevaDeuda2->nro_acuerdo             = $dato->nro_acuerdo;
                                    $nuevaDeuda2->nro_cuota               = $dato->nro_cuota;
                                    $nuevaDeuda2->estado                  = 0; // 0 pagada ????
                                    $nuevaDeuda2->id_opr                  = Auth::user()->id;
                                    if ($dato->imputacion_manual) {
                                        $nuevaDeuda2->imputacion_manual   = $dato->imputacion_manual; // valor 1 para deuda manual
                                    } else {
                                        $nuevaDeuda2->imputacion_manual   = 0; // cuando es proceso de excel
                                    }

                                    $nuevaDeuda2->save();
                                }
                            }
                        } else { //SI ES CONVENIO (nro_cuota > 0 // periodo = 0)
                            //LO BUSCAMOS EN LA TABLA DEUDAS POR EMPRESA+CUOTA+FECHA-DEPOSITO+IMPORTE DEPOSITADO
                            $deuda = Deuda::where('cod_empresa', $dato->cod_empresa)
                                ->where('nro_cuota', $dato->nro_cuota)
                                ->where('fecha_acreditacion', $dato->fecha_deposito)
                                ->where('ipte_depositado', $dato->ipte_depositado)
                                ->exists();
                            //SI SE ENCUENTRA SE DESCARTA POR REPETIDO
                            if (!$deuda) { //HACER INSERT SI NO ENCONTRO / ES UN PAGO CONVENIO
                                $empresa = Empresa::where('cod_empresa', $dato->cod_empresa)
                                    ->first();
                                if ($empresa) {
                                    $insert3++;
                                    $nuevaDeuda3                          = new Deuda;
                                    $nuevaDeuda3->cod_seccional           = $dato->cod_seccional;
                                    $nuevaDeuda3->id_empresa              = $empresa->id_empresa;
                                    $nuevaDeuda3->cod_empresa             = $dato->cod_empresa;
                                    $nuevaDeuda3->tipo_cuenta             = $dato->tipo_cuenta;
                                    $nuevaDeuda3->fecha_acreditacion      = $dato->fecha_deposito;
                                    $nuevaDeuda3->periodo                 = $dato->periodo;
                                    $nuevaDeuda3->cant_afil_titulares     = $dato->cant_afil_titulares;
                                    $nuevaDeuda3->ipte_total_remuneracion = $dato->ipte_total_remuneracion;
                                    $nuevaDeuda3->ipte_depositado         = $dato->ipte_depositado;
                                    $nuevaDeuda3->nro_acuerdo             = $dato->nro_acuerdo;
                                    $nuevaDeuda3->nro_cuota               = $dato->nro_cuota;
                                    $nuevaDeuda3->estado                  = 0; // 0 pagada ????
                                    $nuevaDeuda3->id_opr                  = Auth::user()->id;
                                    if ($dato->imputacion_manual) {
                                        $nuevaDeuda3->imputacion_manual   = $dato->imputacion_manual;
                                    } else {
                                        $nuevaDeuda3->imputacion_manual   = 0; // cuando es proceso de excel
                                    }

                                    $nuevaDeuda3->save();
                                }
                            }
                        }
                    }
                    DB::commit();
                    $cantidad   = $update + $insert + $insert2 + $insert3;
                    $generada   = $update;
                    $extras     = $insert;
                    $noGenerada = $insert2;
                    $convenio   = $insert3;

                    return response()->json(['resultado' => 'ok', 'cantidad' => $cantidad, 'generada' => $generada, 'extras' => $extras, 'noGenerada' => $noGenerada, 'convenio' => $convenio]);
                } catch (Exception $th) {
                    DB::rollback();
                    return  response()->json(['resultado' => "error", 'error' => $th->getMessage()]);
                }
            }

            //$deudaManual = new DeudaController;

            //$deudaManual->saveData($datos); // a va otro controlador a grabar
        } catch (\Throwable $th) {
            return  response()->json(['resultado' => "error", 'error' => $th->getMessage()]);
        }
    }
    public function delete(Request $request)
    {//dd($request->all());
        try {
            $deuda = Deuda::where('id_deuda', $request->id_deuda)
                ->first();
            //$deuda->estado = 2; // eliminada
            $deuda->delete();
            
            // FUNCIONA /////////////////////////////
///////// VER LO DE LOS MENSAJES DE ERROR Y EXITO //////////////

            //return redirect()->back();
            return response()->json(['resultado' => 'ok']);
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return  response()->json(['resultado' => "error", 'error' => $th->getMessage()]);
        }
    }
}
