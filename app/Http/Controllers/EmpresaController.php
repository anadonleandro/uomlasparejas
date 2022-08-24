<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\HistorialEmpresa;
use App\Models\CPostal;
use App\Models\Titular;
use DB;
use Auth;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexEmpresa()
    {
        return view("empresa.index");
    }

    public function getEmpresas()
    {
        $resultados = Empresa::orderBy('nom_empresa')
            ->get();

        foreach ($resultados as $resu) {
            if ($resu->estado == 0) {
                $resu->estado = "ACTIVA";
            } else {
                $resu->estado = "INACTIVA";
            }
        }

        return  response()->json(['resultados' => $resultados]);
    }

    public function create()
    {
        $localidades = CPostal::orderBy('nombre')
            ->get();
        return view("empresa.create", compact('localidades'));
    }

    public function store(Request $request)
    {
        try {
            /// mensajes de error ///
            if ($request->tipoEmpresa == 1 && $request->cod_empresa > 89999) {
                // empresa METALURGICA con valor 90000 o superior
                return  response()->json(['resultados' => "error", 'error' => "Código de Empresa Metalúrgica debe ser MENOR a 90.000"]);
            }
            if ($request->tipoEmpresa == 2 && $request->cod_empresa < 90000) {
                // OTRA  empresa  con valor MENOPR A 90000 
                return  response()->json(['resultados' => "error", 'error' => "Código de OTRAS Empresas (NO Metalúrgicas) debe ser MAYOR a 90.000"]);
            };
            if ($empresa = DB::table('empresas')
                ->where('cod_empresa', $request->cod_empresa)
                ->first()
            ) {
                // si encuentra empresa, ya está cargada (repetida) 
                return  response()->json(['resultados' => "error", 'error' => "El Código: " . $request->cod_empresa . " ya está registrado con la Empresa: " . $empresa->nom_empresa]);
            }
            /// mensajes de error ///

            DB::beginTransaction();
            // si el codigo esta dentro del rango permitido y
            // la empresa no fue cargada previamente, procede a grabar...
            $empresa                         = new Empresa;
            $empresa->id_seccional           = 181;
            $empresa->cod_empresa            = $request->cod_empresa;
            $empresa->nom_empresa            = strtoupper($request->nom_empresa);
            $empresa->cuit                   = strtoupper($request->cuit);
            $empresa->actividad              = strtoupper($request->actividad);
            $empresa->domicilio              = strtoupper($request->domicilio);
            $empresa->id_cpostal             = $request->id_cpostal;
            $empresa->telefono               = strtoupper($request->telefono);
            $empresa->email                  = strtolower($request->email);
            $empresa->fecha_inicio_actividad = $request->fecha_inicio_actividad;
            $empresa->fecha_alta             = $request->fecha_alta;
            // $request->cantidad_obreros ?
            //     $empresa->cantidad_obreros = $request->cantidad_obreros :
            //     $empresa->cantidad_obreros = 0;
            // $request->cantidad_afiliados ?
            //     $empresa->cantidad_afiliados = $request->cantidad_afiliados :
            //     $empresa->cantidad_afiliados = 0;

            $empresa->obs                    = strtoupper($request->obs);
            $empresa->estado                 = 0; // activa
            $empresa->tpempresa              = $request->tipoEmpresa;
            $empresa->id_opr                 = Auth::user()->id;

            $empresa->save();

            DB::commit();
            return  response()->json(['resultados' => "ok"]);
        } catch (\Throwable $th) {
            DB::rollback();
            $error = $th->getMessage();
            return  response()->json(['resultados' => "error", 'error' => $error]);
        }
    }

    public function show(Request $request)
    {
        //BUSCAMOS LA EMPRESA CON EL ID QUE LLEGA DE LA VISTA
        $empresa = Empresa::findOrFail($request->id_empresa);
        //BUSCAMOS LA ULTIMA MODIFICACION
        $empresa_modificado = HistorialEmpresa::select(DB::raw('max(created_at) as fecha_mod'), 'id_opr')
            ->where('id_empresa', $request->id_empresa)
            ->first();
        //BUSCAMOS EL USUARIO QUE MODIFICO
        $usuario_modifico = DB::table('users')
            ->where('id', $empresa_modificado->id_opr)
            ->first();
        //GET DE LOCALIDADES
        $localidades = CPostal::orderBy('nombre')
            ->get();
        //CONTAMOS LA CANTIDAD DE EMPLEADOS DE LA EMPRESA
        $totalEmpleados = Titular::where('id_empresa', $empresa->id_empresa)
            ->count();
        //CONTAMOS EMPLEADOS DE LA EMPRESA AFILIADOS AL GREMIO Y OBRA SOCIAL          
        $afilAmbos = Titular::where('id_empresa', $empresa->id_empresa)
            ->where('afiliado_a',3)
            ->count();
        //CONTAMOS EMPLEADOS DE LA EMPRESA AFILIADOS A LA OBRA SOCIAL  
        $totalObraSocial = Titular::where('id_empresa', $empresa->id_empresa)
            ->where('afiliado_a',1)
            ->count();
        $afilObraSocial=$totalObraSocial+$afilAmbos;
        //CONTAMOS EMPLEADOS DE LA EMPRESA AFILIADOS AL GREMIO           
        $totalGremio = Titular::where('id_empresa', $empresa->id_empresa)
            ->where('afiliado_a',2)
            ->count();  
        $afilGremio=$totalGremio+$afilAmbos;      
        //LOS BUSCAMOS PARA MOSTRAR EN TABLA
        $titulares = Titular::where('id_empresa', $empresa->id_empresa)
            ->select('nro_doc','nom_titular','afiliado_a')
            ->orderBy('nom_titular')
            ->get();
        //LO CONVERTIMOS EN JSON PARA MOSTRAR EN DATATABLE
        $datosEmpleado = json_decode(json_encode($titulares), FALSE);
        
        //dd($datosEmpleado);
        return view("empresa/show", compact('empresa','localidades','datosEmpleado',
        'totalEmpleados','afilObraSocial','afilGremio','empresa_modificado','usuario_modifico'));
    }

    public function edit(Request $request)
    {
        $empresa = Empresa::findOrFail($request->id_empresa);
        $localidades = CPostal::orderBy('nombre')
            ->get();
        return view("empresa.edit", compact('empresa', 'localidades'));
    }

    public function update(Request $request)
    {
        $empresa_aux= Empresa::findOrFail($request->id_empresa);
        try {
            DB::beginTransaction();

            //GUARDAMOS EL REGISTRO EMPRESA ANTES DE SER EDITADO
            $historial_empresa             = new HistorialEmpresa;
            $historial_empresa->id_empresa = $empresa_aux->id_empresa;
            $historial_empresa->empresa    = $empresa_aux; 
            $historial_empresa->id_opr     = Auth::user()->id;
            $historial_empresa->save();

            //COMENZAMOS LA EDICION DEL REGISTRO EMPRESA
            $empresa                         = Empresa::findOrFail($request->id_empresa);
            $empresa->nom_empresa            = strtoupper($request->nom_empresa);
            $empresa->cuit                   = strtoupper($request->cuit);
            $empresa->actividad              = strtoupper($request->actividad);
            $empresa->domicilio              = strtoupper($request->domicilio);
            $empresa->id_cpostal             = $request->id_cpostal;
            $empresa->telefono               = strtoupper($request->telefono);
            $empresa->email                  = strtolower($request->email);
            $empresa->fecha_inicio_actividad = $request->fecha_inicio_actividad;
            $empresa->fecha_alta             = $request->fecha_alta;
            // $request->cantidad_obreros ? // si no llega valor asigna '0'
            //     $empresa->cantidad_obreros = $request->cantidad_obreros :
            //     $empresa->cantidad_obreros = 0;
            // $request->cantidad_afiliados ? // si no llega valor asigna '0'
            //     $empresa->cantidad_afiliados = $request->cantidad_afiliados :
            //     $empresa->cantidad_afiliados = 0;
            $empresa->estado                 = $request->estado;
            $empresa->obs                    = strtoupper($request->obs);
            $empresa->update();

            DB::commit();
            return  response()->json(['resultados' => "ok"]);
        } catch (\Throwable $th) {
            DB::rollback();
            $error = $th->getMessage();
            return  response()->json(['resultados' => "error", 'error' => $error]);
        }
    }
}
