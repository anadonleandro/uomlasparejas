<?php

namespace App\Http\Controllers;

use App\Models\Titular;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\CPostal;
use Illuminate\Support\Facades\DB;
use App\Models\EstadoCivil;
use Illuminate\Support\Facades\Auth;

class TitularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTitular()
    {
        return view("titular.index");
    }

    public function getTitulares()
    {
        try {
            $resultados = Titular::select('nom_empresa','nom_titular', 'nro_doc', 'nombre', 'cpostal', 'id_titular')
                ->join('empresas', 'titulares.id_empresa', '=', 'empresas.id_empresa')
                ->join('cpostales', 'titulares.id_cpostal', '=', 'cpostales.id')
                ->orderBy('nom_titular')
                ->get();
            $empresas = Empresa::get();

            foreach ($resultados as $titular) {
                $titular->id_cpostal = $titular->cpostal . " - " . $titular->nombre;
            }

            return  response()->json(['resultados' => $resultados]);
        } catch (\Throwable $th) {
            return  response()->json(['error' => $th->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresas = Empresa::orderBy('nom_empresa')
            ->get();
        $localidades = CPostal::orderBy('nombre')
            ->get();
        $tiposDocumento = DB::table('documento_tipos')
            ->orderBy('id')
            ->get();
        $estadosCiviles = EstadoCivil::orderBy('nombre')
            ->get();
        $categorias = DB::table('categorias')
            ->orderBy('id')
            ->get();

        return view("titular.create", compact('empresas', 'localidades', 'tiposDocumento', 'estadosCiviles', 'categorias'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $titular                 = new Titular;
            $titular->nro_doc        = $request->nro_doc;
            $titular->tp_doc         = $request->tp_doc;
            $titular->cuil           = $request->cuil;
            $titular->cbu            = $request->cbu;
            $titular->nom_titular    = strtoupper($request->nom_titular);
            $titular->sexo           = $request->sexo;
            $titular->direccion      = strtoupper($request->direccion);
            $titular->id_cpostal     = $request->id_cpostal;
            $titular->mail           = strtolower($request->mail);
            $titular->incapacidad    = $request->incapacidad;
            $titular->ecivil         = $request->ecivil;
            $titular->telefono       = $request->telefono;
            $titular->id_categoria   = $request->id_categoria;
            $titular->id_empresa     = $request->id_empresa;
            $titular->fec_nacimiento = $request->fec_nacimiento;
            $titular->fec_alta       = $request->fec_alta;
            $titular->cod_opr        = Auth::user()->id;
            $titular->afiliado_a     = $request->afiliado_a;
            $titular->obs            = strtoupper($request->obs);

            $titular->save();

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
        $titular = Titular::where('id_titular', $request->id_titular)
            ->orderBy('nom_titular')
            ->first();
        //   dd($titular);
        $empresa = $titular->getEmpresa()->first()->nom_empresa;
        /* $empresa = Empresa::where('id_empresa', $titular->id_empresa)
        ->first();*/
        //dd($empresa);
        $localidad = $titular->getCpostal()->first()->cpostal . " - " . $titular->getCpostal()->first()->nombre;
        $tipoDocumento = DB::table('documento_tipos')
            ->where('id', $titular->tp_doc)
            ->first();
        $estadoCivil = EstadoCivil::orderBy('nombre')
            ->where('id', $titular->ecivil)
            ->first();
        $categoria = DB::table('categorias')
            ->where('id', $titular->id_categoria)
            ->orderBy('id')
            ->first();

        return view("titular/show", compact('empresa', 'localidad', 'titular', 'tipoDocumento', 'estadoCivil', 'categoria'));
    }

    public function edit(Request $request)
    {
        $titular = Titular::findOrFail($request->id_titular);
        $empresas = Empresa::orderBy('nom_empresa')
            ->get();
        $localidades = CPostal::orderBy('nombre')
            ->get();
        $tiposDocumento = DB::table('documento_tipos')
            ->orderBy('id')
            ->get();
        $estadosCiviles = EstadoCivil::orderBy('nombre')
            ->get();
        $categorias = DB::table('categorias')
            ->orderBy('id')
            ->get();
        return view("titular.edit", compact('empresas', 'localidades', 'titular', 'tiposDocumento', 'estadosCiviles', 'categorias'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $titular                 = Titular::findOrFail($request->id_titular);

            $titular->nro_doc        = $request->nro_doc;
            $titular->tp_doc         = $request->tp_doc;
            $titular->cuil           = $request->cuil;
            $titular->cbu            = $request->cbu;
            $titular->nom_titular    = strtoupper($request->nom_titular);
            $titular->sexo           = $request->sexo;
            $titular->direccion      = strtoupper($request->direccion);
            $titular->id_cpostal     = $request->id_cpostal;
            $titular->mail           = strtolower($request->mail);
            $titular->incapacidad    = $request->incapacidad;
            $titular->ecivil         = $request->ecivil;
            $titular->telefono       = $request->telefono;
            $titular->id_categoria   = $request->id_categoria;
            $titular->id_empresa     = $request->id_empresa;
            $titular->fec_nacimiento = $request->fec_nacimiento;
            $titular->fec_alta       = $request->fec_alta;
            $titular->cod_opr        = Auth::user()->id;
            $titular->afiliado_a     = $request->afiliado_a;
            $titular->obs            = strtoupper($request->obs);

            //  dd($titular);

            $titular->update();

            DB::commit();
            return  response()->json(['resultados' => "ok"]);

            //  Session::flash('message', 'TITULAR GUARDADA SATISFACTORIAMENTE..!!!');
            //  return view("titular.index");
        } catch (\Throwable $th) {
            DB::rollback();
            $error = $th->getMessage();
            return  response()->json(['resultados' => "error", 'error' => $error]);

            //  Session::flash('msg', 'ERROR AL GUARDAR TITULAR..!!!' . $th->getMessage());
            //  return view("titular.index");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Titular  $titular
     * @return \Illuminate\Http\Response
     */
    public function destroy(Titular $titular)
    {
        //
    }
}
