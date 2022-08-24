<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Deuda;
use App\Models\Pagoslog;
use Illuminate\Support\Carbon;
use App\Http\Controllers\ExcelArchivoController;
use DB;
use Auth;
use Session;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DeudaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createDeuda()
    {
        $empresas = Empresa::all();
        // TRAER SOLO ACTIVAS /////////////////////
        return view("empresa.deuda", compact('empresas'));
    }

    public function storeDeuda(Request $request)
    {
        try {
            DB::beginTransaction();
            $cantidad = 0; // cantidad de deudas generadas

            if ($request->id_empresa_desde > $request->id_empresa_hasta) {
                $error = "El Código de Empresa DESDE es Mayor al Código de Empresa HASTA";
                return  response()->json(['resultados' => "errorEmpresa", 'msj' => $error]);
            } else {
                $empresas = Empresa::whereBetween('id_empresa', [$request->id_empresa_desde, $request->id_empresa_hasta])
                    ->get();

                foreach ($empresas as $empresa) {
                    $tipo_cuenta = $request->tipo_cuenta;
                    $cont = 0;
                    while ($cont < count($tipo_cuenta)) {
                        // verificacion de deuda generada previamente
                        $yaProcesado = $this->checkDeudaYaProcesada($empresa->id_empresa, $request->periodo, $tipo_cuenta[$cont]);

                        if (!$yaProcesado) {
                            // si no fue procesado previamente, genera deuda
                            $deuda = new Deuda;
                            $deuda->periodo = $request->periodo;
                            $deuda->estado = 1; // adeudada
                            $deuda->fecha_vto = $request->fecha_vto;
                            $deuda->cod_seccional = 181;
                            $deuda->id_empresa = $empresa->id_empresa;
                            $deuda->cod_empresa = $empresa->cod_empresa; //agregado codigo
                            $deuda->tipo_cuenta = $tipo_cuenta[$cont];
                            $deuda->id_opr = Auth::user()->id;
                            $cantidad++;
                            $deuda->save();
                        }
                        $cont++;
                    }
                }
            }

            DB::commit();
            return  response()->json(['resultados' => "ok", 'cantidad' => $cantidad]);
        } catch (\Throwable $th) {
            DB::rollback();
            $error = $th->getMessage();
            return  response()->json(['resultados' => "error", 'error' => $error]);
        }
    }

    public function checkDeudaYaProcesada($empresa_id, $periodo, $tipo_cuenta)
    { // verifica que la empresa no haya generado deuda previamente

        $deuda = Deuda::where('id_empresa', $empresa_id)
            ->where('periodo', $periodo)
            ->where('tipo_cuenta', $tipo_cuenta)
            ->first();

        !$deuda ? $deuda = false : $deuda = true;
        // devuelve TRUE si ya proceso

        return $deuda;
    }

    ////////EXCEL////////////////////////////////////////////////////
    function procesaDeuda()
    {
        return view("empresa.procesaExcel");
    }

    function importarExcel(Request $request)
    {
        // mensaje si elegio tipo de archivo incorrecto
        $rules = [
            'uploaded_file' => 'required|file|mimes:xls,xlsx'
        ];
        $mensage = [
            'mimes' => 'Tipo de Archivo NO es Excel!'
        ];
        $this->validate($request, $rules, $mensage);
        /// proceso del excel
        $archivo = $request->file('uploaded_file');
        try {
            $spreadsheet = IOFactory::load($archivo->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(1, $row_limit);
            $column_range = range('K', $column_limit);
            $startcount = 1;
            $data = array();
            foreach ($row_range as $row) {
                $data[] = [
                    'tipo_cuenta'             => $sheet->getCell('A' . $row)->getValue(),
                    'cod_seccional'           => $sheet->getCell('B' . $row)->getValue(),
                    'cod_empresa'             => $sheet->getCell('C' . $row)->getValue(),
                    'cuit_empresa'            => $sheet->getCell('D' . $row)->getValue(),
                    'fecha_deposito'          => $sheet->getCell('E' . $row)->getValue(),
                    'periodo'                 => $sheet->getCell('F' . $row)->getValue(),
                    'cant_afil_titulares'     => $sheet->getCell('G' . $row)->getValue(),
                    'ipte_total_remuneracion' => $sheet->getCell('H' . $row)->getValue(),
                    'ipte_depositado'         => $sheet->getCell('I' . $row)->getValue(),
                    'nro_acuerdo'             => $sheet->getCell('J' . $row)->getValue(),
                    'nro_cuota'               => $sheet->getCell('K' . $row)->getValue(),
                    'fecha_proceso'           => Carbon::now()->format('Y-m-d'),
                    'nombre_archivo'          => $archivo->getClientOriginalName(),
                    'id_opr'                  => Auth::user()->id,
                ];
                $startcount++;
            }

            // $data es la INFORMACION RECIBIDA EN ARCHIVO
            // remueve registros duplicados ////////////
            $quitaDuplicados = array_unique($data, SORT_REGULAR);

            // re indexa los resultados
            $data = array_values($quitaDuplicados);

            //cuento la cantidad de registros que quedaron
            $cantidad = count($data);

            //los recorro para ver si existe un registro que tenga 
            //tipo_cuenta = null, cod_empresa = null, ipte_total_remuneracion = null
            // for ($i = 0; $i < $cantidad; $i++) {
            //     //recorro las cantidades que quedaron
            //     //despues de eliminar los duplicados
            //     if (
            //         is_null($data[$i]['tipo_cuenta'])
            //         && is_null($data[$i]['cod_empresa'])
            //         && is_null($data[$i]['ipte_total_remuneracion'])
            //     ) {
            //         // elimino el registro que cumple con la condicion
            //         unset($data[$i]);
            //     }
            // }

            //busco la deuda para saber si algun registro del excel ya existe
            for ($i = 0; $i < $cantidad; $i++) {
                $periodoFormat = substr($data[$i]['periodo'], -6, 4) . "-" . substr($data[$i]['periodo'], -2, 2);
                $deudas = Deuda::where('cod_empresa', $data[$i]['cod_empresa'])
                    ->where('tipo_cuenta', $data[$i]['tipo_cuenta'])                    
                    ->where('periodo', $periodoFormat)                    
                    ->get();
                    //dd($deudas);
                if ($deudas) {                    
                    foreach ($deudas as $deuda) {
                        $fecDepositoFormat = substr($data[$i]['fecha_deposito'], -8, 4) . "-" . substr($data[$i]['fecha_deposito'], -4, 2) . "-" . substr($data[$i]['fecha_deposito'], -2, 2);
                        if ($deuda->fecha_acreditacion == $fecDepositoFormat &&
                            $deuda->cant_afil_titulares == $data[$i]['cant_afil_titulares'] &&
                            $deuda->ipte_depositado == $data[$i]['ipte_depositado']) {
                                //dd($deuda);
                                // elimino el registro que cumple con la condicion
                                unset($data[$i]);
                                break;
                        }
                    }
                }
            }

            // re indexa los resultados
            $data = array_values($data);
            //dd($data);
            //datosExcel es lo que se manda a la vista
            $datosExcel = json_decode(json_encode($data), FALSE);
            //dd($datosExcel);
            //dd(!$data);
            if (!$datosExcel) {
                // si los valores tipo_cuenta, cod_empresa y ipte_total_remuneracion
                // son nulos, es porque el archivo está vacío, MUESTRA EN VISTA LA TABLA SIN DATOS
                Session::flash('message', 'EL ARCHIVO SELECCIONADO NO TIENE REGISTROS PARA PROCESAR');
                return view("empresa.procesaExcel", compact('datosExcel'));
            } else {
                // PROCESO NORMAL, EL ARCHIVO TIENE INFORMACION
                $erroresEmpresa = $this->controlEmpresa($datosExcel);
                $this->formatNumber($datosExcel);

                switch ($datosExcel[0]->tipo_cuenta) {
                        // carga el nombre del concepto para vista
                    case 1:
                        $concepto = "OBRA SOCIAL";
                        break;
                    case 2:
                        $concepto = "2,5% SINDICAL";
                        break;
                    case 3:
                        $concepto = "SEGURO";
                        break;
                    case 4:
                        $concepto = "2% SINDICAL";
                        break;
                    case 5:
                        $concepto = "ACUERDO DE PAGO";
                        break;
                }
                $empresas = Empresa::all();

                return view("empresa.procesaExcel", compact('datosExcel', 'empresas', 'concepto', 'erroresEmpresa'));
            }
        } catch (Exception $th) {
            $error = $th->getMessage();
            return  response()->json(['resultado' => "error", 'error' => $error]);
        }
    }

    public function formatNumber($datosExcel)
    { // formato tipo $12.345,58
        foreach ($datosExcel as $dato) {
            if ($dato->ipte_total_remuneracion != 0) { // genera otro campo diferente para mostrar en vista
                $dato->ipte_total_formateado = number_format($dato->ipte_total_remuneracion, 2, ',', '.');
            } else { // si esta en cero, lo genera igual para mostrar
                $dato->ipte_total_formateado = 0;
            }
            if ($dato->ipte_depositado != 0) { // genera otro campo diferente para mostrar en vista
                $dato->ipte_depositado_formateado = number_format($dato->ipte_depositado, 2, ',', '.');
            } else { // si esta en cero, lo genera igual para mostrar
                $dato->ipte_depositado_formateado = 0;
            }
        }
    }

    public function controlEmpresa($datosExcel)
    {
        try {
            // controla que la empresa exista en tabla empresa
            // que la deuda haya sido generadas
            $erroresEmpresa = []; // array de empresas con errores

            foreach ($datosExcel as $datos) {
                $datos->tieneError = false; // si encontro error, asi no lo vuelve a agregar a array
                $datos->mensajeError = ""; // inicia propiedad donde se agregaran mensajes de error
                $nom_empresa = Empresa::where('cod_empresa', $datos->cod_empresa)
                    ->select('nom_empresa')
                    ->first();

                if ($nom_empresa) {
                    $datos->empresa = $nom_empresa->nom_empresa; //ASIGNA NOMBRE DE LA EMPRESA SI EXISTE
                } else {
                    $datos->empresa = "EMPRESA INEXISTENTE";
                    $datos->mensajeError .= "Empresa Inexistente - ";
                    //carga array con empresas inexistentes
                    if (!$datos->tieneError) {
                        $datos->tieneError = true; // asi no vuelve a cargar en array de errores
                        array_push($erroresEmpresa, $datos);
                    }
                }
                if ($datos->periodo != 0) {
                    // si tiene periodo cargado lo formatea con guiones
                    $periodoFormateado = substr($datos->periodo, 0, -2) . "-" .   substr($datos->periodo, -2);
                    $datos->periodo = $periodoFormateado;

                    //CONTROL - BUSCAMOS LA DEUDA
                    $deuda = Deuda::where('cod_empresa', $datos->cod_empresa)
                        ->where('periodo', $periodoFormateado)
                        ->where('tipo_cuenta', $datos->tipo_cuenta)
                        ->first();

                    if (!$deuda) { // si no encontro deuda generada
                        $datos->mensajeError .= "Deuda no generada"; // '.=' concatena mensajes
                        //carga array con deudas no generadas
                        if (!$datos->tieneError) {
                            $datos->tieneError = true; // asi no vuelve a cargar en array de errores
                            array_push($erroresEmpresa, $datos);
                        }
                    }
                }
            }
            if ($erroresEmpresa) {
                // si hay empresas no encontradas
                return $erroresEmpresa;
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function saveData(Request $request)
    { // updates e inserts en tabla Deudas

        // llega un archivo excel
        // formatea lo que llega del request como json, a objeto
        $datosProceso = json_decode($request->get('items'));

        // VERIFICA QUE datosProceso TENGA INFORMACION (archivo NO vacio)
        if (is_null($datosProceso[0]->tipo_cuenta) && is_null($datosProceso[0]->cod_empresa) && is_null($datosProceso[0]->ipte_total_remuneracion)) {
            // si son los tres campos nulos, no hay informacion en archivo excel
            try {
                // lo unico que hace al recibir informacion nula
                // es enviar nombre de archivo a tabla excel_pagos
                $nombreArchivo = $datosProceso[0]->nombre_archivo;
                $archivo = new ExcelArchivoController; // va a controlador a guardar nombre de archivo
                $cantidad = 0;
                $generada = 0;
                $extras = 0;
                $noGenerada = 0;
                $convenio = 0;
                $archivo->guardarNombreArchivo($nombreArchivo, $cantidad, $generada, $extras, $noGenerada, $convenio);
                return response()->json(['resultado' => 'ok', 'cantidad' => 0, 'generada' => 0, 'extras' => 0, 'noGenerada' => 0, 'convenio' => 0]);
            } catch (\Throwable $th) {
                $error = $th->getMessage();

                // Session::flash('msg', 'ERROR AL GUARDAR DEUDA..!!!' . $th->getMessage());
                return  response()->json(['resultado' => "error", 'error' => $error]);
            }
        } else {
            // PROCESO NORMAL DE CARGA DE EXCEL o DEUDA MANUAL///////////////////////////
            $update = $insert = $insert2 = $insert3 = 0;
            $this->checkEmpresaInexistente($datosProceso); // chequea existencia de empresa en BD
            try {
                DB::beginTransaction();
                foreach ($datosProceso as $dato) { // FORMATEAMOS LA FECHA DE DEPOSITO PARA UTILIZAR EN CONDICION DE BUSQUEDA
                    if (strlen($dato->fecha_deposito) == 8) {
                        // en excel la fecha viene formato AAAAMMDD (8 caract.)
                        // hay q formatearla con guiones, no así para el proceso Deuda Manual
                        $fecDepositoFormat = substr($dato->fecha_deposito, -8, 4) . "-" . substr($dato->fecha_deposito, -4, 2) . "-" . substr($dato->fecha_deposito, -2, 2);
                        $dato->fecha_deposito = $fecDepositoFormat;
                    }
                    // if (strlen($dato->periodo) == 6) {
                    //     // en excel la fecha viene formato AAAAMM (6 caract.)
                    //     // hay q formatearla con guiones, no así para el proceso Deuda Manual
                    //     $periodoFormat = substr($dato->periodo, -6, 4) . "-" . substr($dato->fecha_deposito, -2, 2);
                    //     $dato->periodo = $periodoFormat;
                    // }

                    if ($dato->nro_cuota == 0 && $dato->periodo !== 0) { //CONTROL SI NO ES CONVENIO
                        //LO BUSCAMOS EN LA TABLA DEUDAS POR:
                        // EMPRESA + TIPO-CUENTA + FECHA-DEPOSITO + PERIODO
                        $deuda = Deuda::where('cod_empresa', $dato->cod_empresa)
                            ->where('tipo_cuenta', $dato->tipo_cuenta)
                            ->where('periodo', $dato->periodo)
                            ->first();

                        if ($deuda) { //SI EXISTE LA DEUDA
                            //SI NO COINCIDE IMPORTE DEPOSITADO, CANTIDAD EMPLEADOS PAGADOS Y FECHA DE PAGO
                            if (
                                $dato->ipte_depositado !== $deuda->ipte_depositado
                                && $dato->cant_afil_titulares !== $deuda->cant_afil_titulares
                                && $dato->fecha_deposito !== $deuda->fecha_acreditacion
                            ) {
                                if ($deuda->ipte_depositado == 0) {
                                    //HACER UPDATE SI EL IMPORTE-DEPOSITADO EN DEUDA ES 0
                                    $update++;
                                    $deuda->ipte_depositado         = $dato->ipte_depositado;
                                    $deuda->fecha_acreditacion      = $dato->fecha_deposito;
                                    $deuda->cant_afil_titulares     = $dato->cant_afil_titulares;
                                    $deuda->ipte_total_remuneracion = $dato->ipte_total_remuneracion;
                                    $deuda->nro_acuerdo             = 0;
                                    $deuda->nro_cuota               = $dato->nro_cuota;
                                    $deuda->estado                  = 0; //PAGADA
                                    $deuda->id_opr                  = Auth::user()->id;
                                    $deuda->imputacion_manual       = 0; // cuando es proceso de excel

                                    $deuda->update();
                                    //dd("bandera 1");
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
                                        $nuevaDeuda->nro_acuerdo             = 0;
                                        $nuevaDeuda->nro_cuota               = $dato->nro_cuota;
                                        $nuevaDeuda->estado                  = 0; // 0 pagada ????
                                        $nuevaDeuda->imputacion_manual       = 0; // cuando es proceso de excel
                                        $nuevaDeuda->id_opr                  = Auth::user()->id;

                                        $nuevaDeuda->save();
                                        //dd("bandera 2");
                                    }
                                }
                            }
                            //dd("bandera 3");
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
                                $nuevaDeuda2->nro_acuerdo             = 0;
                                $nuevaDeuda2->nro_cuota               = $dato->nro_cuota;
                                $nuevaDeuda2->estado                  = 0; // 0 pagada ????
                                $nuevaDeuda2->id_opr                  = Auth::user()->id;
                                $nuevaDeuda2->imputacion_manual       = 0; // cuando es proceso de excel

                                $nuevaDeuda2->save();
                                //dd("bandera 4");
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
                                $nuevaDeuda3->nro_acuerdo             = 0;
                                $nuevaDeuda3->nro_cuota               = $dato->nro_cuota;
                                $nuevaDeuda3->estado                  = 0; // 0 pagada ????
                                $nuevaDeuda3->id_opr                  = Auth::user()->id;
                                $nuevaDeuda3->imputacion_manual       = 0; // cuando es proceso de excel

                                $nuevaDeuda3->save();
                                // dd("bandera 5");
                            }
                        }
                    }
                }
                DB::commit();
                $cantidad = $update + $insert + $insert2 + $insert3;
                $generada = $update;
                $extras = $insert;
                $noGenerada = $insert2;
                $convenio = $insert3;

                // NO es Pago manual, envia nombre de archivo
                $nombreArchivo = $datosProceso[0]->nombre_archivo;
                $archivo = new ExcelArchivoController; // va a controlador a guardar nombre de archivo
                $archivo->guardarNombreArchivo($nombreArchivo, $cantidad, $generada, $extras, $noGenerada, $convenio);

                return response()->json(['resultado' => 'ok', 'cantidad' => $cantidad, 'generada' => $generada, 'extras' => $extras, 'noGenerada' => $noGenerada, 'convenio' => $convenio]);
            } catch (Exception $th) {
                DB::rollback();

                $error = $th->getMessage();
                // Session::flash('message', 'ERROR AL GUARDAR DEUDA..!!!' . $th->getMessage());
                return  response()->json(['resultado' => "error", 'error' => $error]);
            }
        }
    }

    public function checkEmpresaInexistente($datosProceso)
    { // si la empresa no está grabada en DB, la graba en pagos log
        $cont = 0;
        foreach ($datosProceso as $dato) {
            //busca la empresa
            $empresa = Empresa::where('cod_empresa', $dato->cod_empresa)
                ->first();
            // busca si ya se registro en pagos log
            $empresaLog = Pagoslog::where('cod_empresa', $dato->cod_empresa)
                ->first();
            if (!$empresa && !$empresaLog) {
                // no encontro empresa y no se registro previamente en logs, INSERT EN PAGOSLOG
                $log                           = new Pagoslog;
                $log->tipo_cuenta              = $dato->tipo_cuenta;
                $log->cod_seccional            = $dato->cod_seccional;
                $log->cod_empresa              = $dato->cod_empresa;
                $log->cuit_empresa             = $dato->cuit_empresa;
                $log->fecha_deposito           = substr($dato->fecha_deposito, -8, 4) . "-" . substr($dato->fecha_deposito, -4, 2) . "-" . substr($dato->fecha_deposito, -2, 2);
                $log->periodo                  = $dato->periodo;
                $log->cant_afil_titulares      = $dato->cant_afil_titulares;
                $log->ipte_total_remuneracion  = $dato->ipte_total_remuneracion;
                $log->ipte_depositado          = $dato->ipte_depositado;
                $log->nro_acuerdo              = $dato->nro_acuerdo;
                $log->nro_cuota                = $dato->nro_cuota;
                $log->fecha_proceso            = $dato->fecha_proceso; // es esta que viene en registro o la actual???
                $log->nombre_archivo           = $dato->nombre_archivo;
                $log->id_opr                   = $dato->id_opr;
                $log->tipo_error               = "EMPRESA NO CARGADA EN BASE DE DATOS";
                $cont++;

                $log->save();
            } elseif ($empresaLog) { // no esta en BD pero si tabla log
                $empLog = Pagoslog::where('fecha_proceso', $dato->fecha_proceso)
                    ->where('tipo_cuenta', $dato->tipo_cuenta)
                    ->where('ipte_total_remuneracion', $dato->ipte_total_remuneracion)
                    ->where('ipte_depositado', $dato->ipte_depositado)
                    ->first();
                // comprueba que no se hayan grabado el mismo dia los logs
                if (!$empLog) {
                    // si no hay coincidencia, graba log
                    $log                           = new Pagoslog;
                    $log->tipo_cuenta              = $dato->tipo_cuenta;
                    $log->cod_seccional            = $dato->cod_seccional;
                    $log->cod_empresa              = $dato->cod_empresa;
                    $log->cuit_empresa             = $dato->cuit_empresa;
                    $log->fecha_deposito           = substr($dato->fecha_deposito, -8, 4) . "-" . substr($dato->fecha_deposito, -4, 2) . "-" . substr($dato->fecha_deposito, -2, 2);
                    $log->periodo                  = $dato->periodo;
                    $log->cant_afil_titulares      = $dato->cant_afil_titulares;
                    $log->ipte_total_remuneracion  = $dato->ipte_total_remuneracion;
                    $log->ipte_depositado          = $dato->ipte_depositado;
                    $log->nro_acuerdo              = $dato->nro_acuerdo;
                    $log->nro_cuota                = $dato->nro_cuota;
                    $log->fecha_proceso            = $dato->fecha_proceso; // es esta que viene en registro o la actual???
                    $log->nombre_archivo           = $dato->nombre_archivo;
                    $log->id_opr                   = $dato->id_opr;
                    $log->tipo_error               = "EMPRESA NO CARGADA EN BASE DE DATOS";
                    $cont++;

                    $log->save();
                }
            }
        }
    }
}
