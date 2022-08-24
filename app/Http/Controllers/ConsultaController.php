<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Empresa;
use App\Models\Deuda;
use App\Models\Pagoslog;
use App\Models\Titular;
use Illuminate\Http\Request;


class ConsultaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function consultaDeuda()
    {
        $empresas = Empresa::all();
        return view("empresa.consultaDeuda", compact('empresas'));
    }

    public function getResultadoConsultaDeuda(Request $request)
    {
        try {
            $empresa_inicio = $request->empresa_desde;
            $empresa_fin = $request->empresa_hasta;
            if ($empresa_inicio > $empresa_fin) {
                // SI COLOCO UNA EMPRESA MAYOR AL INICIO, LAS INVIERTE
                $empresa_inicio = $request->empresa_hasta;
                $empresa_fin = $request->empresa_desde;
            }

            $periodo_desde = $request->periodo_desde;
            $periodo_hasta = $request->periodo_hasta;
            if ($request->periodo_hasta < $request->periodo_desde) {
                // SI fecha periodo desde mayor a hasta, LAS INVIERTE
                $periodo_desde = $request->periodo_hasta;
                $periodo_hasta = $request->periodo_desde;
            }

            switch ($request->concepto) {
                case 0: // todos los conceptos
                    switch ($request->estado) {
                        case 0: // TODOS LOS CONCEPTOS Y ESTADO PAGADOS
                            $resultados = Deuda::whereBetween('id_empresa', [$empresa_inicio, $empresa_fin])
                                ->whereBetween('periodo', [$periodo_desde, $periodo_hasta])
                                ->where('estado', $request->estado)
                                ->get();

                            $this->evaluateConcepto($resultados);
                            $this->evaluateNomEmpresa($resultados);
                            $this->formatNumber($resultados);
                            $parametros = $this->getParametros($empresa_inicio, $empresa_fin, $request);

                            return response()->json(['resultados' => $resultados, 'parametros' => $parametros]);
                            break;

                        case 1: // TODOS LOS CONCEPTOS Y ESTADO ADEUDADOS
                            $resultados = Deuda::whereBetween('id_empresa', [$empresa_inicio, $empresa_fin])
                                ->whereBetween('periodo', [$periodo_desde, $periodo_hasta])
                                ->where('estado', $request->estado)
                                ->get();

                            $this->evaluateConcepto($resultados);
                            $this->evaluateNomEmpresa($resultados);
                            $this->formatNumber($resultados);
                            $parametros = $this->getParametros($empresa_inicio, $empresa_fin, $request);

                            return  response()->json(['resultados' => $resultados, 'parametros' => $parametros]);
                            break;

                        default: // todos los estados (adeudado y pagado)
                            $resultados = Deuda::whereBetween('id_empresa', [$empresa_inicio, $empresa_fin])
                                ->whereBetween('periodo', [$periodo_desde, $periodo_hasta])
                                ->get();

                            $this->evaluateConcepto($resultados);
                            $this->evaluateNomEmpresa($resultados);
                            $this->formatNumber($resultados);
                            $parametros = $this->getParametros($empresa_inicio, $empresa_fin, $request);

                            return response()->json(['resultados' => $resultados, 'parametros' => $parametros]);
                            break;
                    }

                    break;

                default: // UN SOLO CONCEPTO
                    switch ($request->estado) {
                        case 0: // ESTADO PAGADA
                            $resultados = Deuda::whereBetween('id_empresa', [$empresa_inicio, $empresa_fin])
                                ->where('tipo_cuenta', $request->concepto)
                                ->whereBetween('periodo', [$periodo_desde, $periodo_hasta])
                                ->where('estado', $request->estado)
                                ->get();

                            $this->evaluateConcepto($resultados);
                            $this->evaluateNomEmpresa($resultados);
                            $this->formatNumber($resultados);
                            $parametros = $this->getParametros($empresa_inicio, $empresa_fin, $request);

                            return response()->json(['resultados' => $resultados, 'parametros' => $parametros]);
                            break;

                        case 1: // ESTADO ADEUDADA
                            $resultados = Deuda::whereBetween('id_empresa', [$empresa_inicio, $empresa_fin])
                                ->where('tipo_cuenta', $request->concepto)
                                ->whereBetween('periodo', [$periodo_desde, $periodo_hasta])
                                ->where('estado', $request->estado)
                                ->get();

                            $this->evaluateConcepto($resultados);
                            $this->evaluateNomEmpresa($resultados);
                            $this->formatNumber($resultados);
                            $parametros = $this->getParametros($empresa_inicio, $empresa_fin, $request);

                            return response()->json(['resultados' => $resultados, 'parametros' => $parametros]);
                            break;

                        default: // todos los estados (pagada y adeudada)
                            $resultados = Deuda::whereBetween('id_empresa', [$empresa_inicio, $empresa_fin])
                                ->whereBetween('periodo', [$periodo_desde, $periodo_hasta])
                                ->where('tipo_cuenta', $request->concepto)
                                ->get();

                            $this->evaluateConcepto($resultados);
                            $this->evaluateNomEmpresa($resultados);
                            $this->formatNumber($resultados);
                            $parametros = $this->getParametros($empresa_inicio, $empresa_fin, $request);

                            return response()->json(['resultados' => $resultados, 'parametros' => $parametros]);
                            break;
                    }
                    break;
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function formatNumber($resultados)
    {
        foreach ($resultados as $dato) {
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

    public function consultaConvenio()
    {
        $empresas = Empresa::all();
        return view("empresa.consultaConvenio", compact('empresas'));
    }

    public function getResultadoConsultaConvenio(Request $request)
    { // dd($request->all());
        try {
            $empresa_inicio = $request->empresa_desde;
            $empresa_fin = $request->empresa_hasta;
            if ($empresa_inicio > $empresa_fin) {
                // SI COLOCO UNA EMPRESA MAYOR AL INICIO, LAS INVIERTE
                $empresa_inicio = $request->empresa_hasta;
                $empresa_fin = $request->empresa_desde;
            }

            $fecha_desde = $request->fecha_desde;
            $fecha_hasta = $request->fecha_hasta;
            if ($request->fecha_hasta < $request->fecha_desde) {
                // SI fecha periodo desde mayor a hasta, LAS INVIERTE
                $fecha_desde = $request->fecha_hasta;
                $fecha_hasta = $request->fecha_desde;
            }

            switch ($request->concepto) {
                case 0: // TODOS LOS CONCEPTOS
                    $resultados = Deuda::whereBetween('id_empresa', [$empresa_inicio, $empresa_fin])
                        ->where('nro_cuota', '!=', 0) // agrego esto que diferencia a convenio, creo...  
                        ->whereBetween('fecha_acreditacion', [$fecha_desde, $fecha_hasta])
                        ->get();

                    $this->evaluateConcepto($resultados);
                    $this->evaluateNomEmpresa($resultados);
                    $this->formatNumber($resultados);
                    //$parametros = $this->getParametros($empresa_inicio, $empresa_fin, $request);
                    return response()->json(['resultados' => $resultados]);
                    break;

                default: // UN SOLO CONCEPTO
                    $resultados = Deuda::whereBetween('id_empresa', [$empresa_inicio, $empresa_fin])
                        ->where('nro_cuota', '!=', 0) // agrego esto que diferencia a convenio, creo...  
                        ->where('tipo_cuenta', $request->concepto)
                        ->whereBetween('fecha_acreditacion', [$fecha_desde, $fecha_hasta])
                        ->get();

                    $this->evaluateConcepto($resultados);
                    $this->evaluateNomEmpresa($resultados);
                    $this->formatNumber($resultados);
                    //$parametros = $this->getParametros($empresa_inicio, $empresa_fin, $request);
                    return response()->json(['resultados' => $resultados]);
                    break;
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    private function getParametros($inicio, $fin, $request)
    {
        try {
            $empresaInicio = Empresa::where('id_empresa', $inicio)
                ->select('nom_empresa', 'cod_empresa')
                ->first();
            $nomInicio = $empresaInicio->cod_empresa . " - " . $empresaInicio->nom_empresa;

            $empresaFin = Empresa::where('id_empresa', $fin)
                ->select('nom_empresa', 'cod_empresa')
                ->first();
            $nomFin = $empresaFin->cod_empresa . " - " . $empresaFin->nom_empresa;

            switch ($request->tipo_cuenta) {
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
                case 0:
                    $concepto = "TODOS";
                    break;
            }

            switch ($request->estado) {
                case 0:
                    $estado = "PAGADA";
                    break;
                case 1:
                    $estado = "ADEUDADA";
                    break;
                case 2:
                    $estado = "TODOS";
                    break;
            }

            $periodo_desde = substr($request->periodo_desde, -2) . " / " . substr($request->periodo_desde, 0, -3);
            $periodo_hasta = substr($request->periodo_hasta, -2) . " / " . substr($request->periodo_hasta, 0, -3);
            // formato mm / aaaa
            $variables = ['nomInicio' => $nomInicio, 'nomFin' => $nomFin, 'concepto' => $concepto, 'estado' => $estado, 'periodo_desde' => $periodo_desde, 'periodo_hasta' => $periodo_hasta];
            // NOMBRES A ENVIAR AL pdf
            return  $variables;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    private function evaluateNomEmpresa($resultados)
    {
        foreach ($resultados as $resu) {
            $empresa = Empresa::where('id_empresa', $resu->id_empresa)
                ->select('nom_empresa', 'cod_empresa')
                ->first();
            $titulares = Titular::where('id_empresa', $resu->id_empresa)->count();
            
            $resu->titularesEmpresa = $titulares;
            $resu->nom_empresa = $empresa->nom_empresa . " - " . $empresa->cod_empresa;
        }
    }

    private function evaluateConcepto($resultados)
    {
        foreach ($resultados as $resu) {
            switch ($resu->tipo_cuenta) {
                case 1:
                    $resu->tipo_cuenta = "OBRA SOCIAL";
                    break;
                case 2:
                    $resu->tipo_cuenta = "2,5% SINDICAL";
                    break;
                case 3:
                    $resu->tipo_cuenta = "SEGURO";
                    break;
                case 4:
                    $resu->tipo_cuenta = "2% SINDICAL";
                    break;
                case 5:
                    $resu->tipo_cuenta = "ACUERDO DE PAGO";
                    break;
            }
        }
        return $resultados;
    }

    public function erroresPagos()
    {
        //$empresas = Empresa::all();
        return view("empresa.erroresPagos");
    }

    public function getResultadoConsultaErrores(Request $request)
    {
        //dd($request->all());
        try {
            $fecha_desde = $request->fecha_desde;
            $fecha_hasta = $request->fecha_hasta;
            if ($request->fecha_hasta < $request->fecha_desde) {
                // SI fecha desde es mayor a hasta, LAS INVIERTE
                $fecha_desde = $request->fecha_hasta;
                $fecha_hasta = $request->fecha_desde;
            }
            $resultados = PagosLog::whereBetween('fecha_proceso', [$fecha_desde, $fecha_hasta])
                ->get();
            foreach ($resultados as $resultado) { //MUESTRA EL CODIGO CON EL TEXTO INEXISTENTE
                $resultado->cod_empresa = $resultado->cod_empresa . " - " . $resultado->tipo_error;
            }
            $this->evaluateConcepto($resultados); //PONE TEXTO AL CODIGO DE CONCEPTO

            return response()->json(['resultados' => $resultados]);
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
