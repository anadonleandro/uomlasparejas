<?php

namespace App\Http\Controllers;

use App\Models\Familiar;
use App\Models\CPostal;
use App\Models\EstadoCivil;
use Illuminate\Http\Request;
use App\Models\Titular;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FamiliarController extends Controller
{
    public function pocesoIdTitular()
    {   // graba id_titular en tabla familiares
        // en relacion a nro_doc_tit con nro_doc(en tabla titulares)
        $familiaresTodos = new Familiar;
        $familiaresTodos = Familiar::orderBy('nro_doc_tit')->get();
        $titularesTodos = Titular::orderBy('nro_doc')->get();
        foreach ($familiaresTodos as $familiar) {
            foreach ($titularesTodos as $titular) {
                if ($familiar->nro_doc_tit == $titular->nro_doc) {
                    $familiar->id_titular = $titular->id_titular;
                }
            }
            $familiar->save();
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFamiliar()
    { //busqueda de familiares
        return view("familiar.index");
    }

    public function getFamiliares(Request $request)
    {
        $opcion = $request->opcion; // id de la opcion del select q eligio en la vista
        $parametro = $request->parametro;
        switch ($opcion) {
            case '1': // buscamos por nombre
                $resultados = DB::table('familiares')
                    ->select('*')
                    ->join('titulares', 'familiares.nro_doc_tit', '=', 'titulares.nro_doc')
                    ->join('vinculos', 'familiares.vinculo', '=', 'vinculos.id')
                    ->where('nom_familiar', 'LIKE', '%' . $parametro . '%')
                    ->orderBy('familiares.nom_familiar')
                    ->get();
                break;
            case '2': // buscamos por DNI
                $resultados = DB::table('familiares')
                    ->select('*')
                    ->join('titulares', 'familiares.nro_doc_tit', '=', 'titulares.nro_doc')
                    ->join('vinculos', 'familiares.vinculo', '=', 'vinculos.id')
                    ->where('familiares.nro_doc', $parametro)
                    ->orderBy('familiares.nom_familiar')
                    ->get();
                break;
        }

        return  response()->json(['resultados' => $resultados]);
    }

    public function listadoFamiliar(Request $request)
    { // listado de familiares
        $titular = Titular::where('id_titular', $request->id_titular)
            ->first();
        $familiares = Familiar::where('nro_doc_tit', $titular->nro_doc)
            ->orderBy('nom_familiar')
            ->get();

        $vinculos = DB::table('vinculos')
            ->orderBy('nom_vinculo')
            ->get();

        return view("familiar.index_listado", compact('titular', 'familiares', 'vinculos'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $titular = Titular::where('id_titular', $request->id_titular)
            ->first();
        $localidades = CPostal::orderBy('nombre')
            ->get();
        $tiposDocumento = DB::table('documento_tipos')
            ->orderBy('id')
            ->get();
        $estadosCiviles = EstadoCivil::orderBy('nombre')
            ->get();
        $vinculos = DB::table('vinculos')
            ->orderBy('nom_vinculo')
            ->get();

        return view("familiar.create", compact('localidades', 'tiposDocumento', 'estadosCiviles', 'titular', 'vinculos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $titular = Titular::findOrFail($request->id_titular);

            $familiar                 = new Familiar;

            $familiar->nro_doc_tit    = $titular->nro_doc; //// check!!!
            $familiar->id_titular     = $titular->id_titular;
            $familiar->nro_doc        = $request->nro_doc;
            $familiar->tp_doc         = $request->tp_doc;
            $familiar->cuil           = $request->cuil;
            $familiar->nom_familiar   = strtoupper($request->nom_familiar);
            $familiar->sexo           = $request->sexo;
            $familiar->direccion      = strtoupper($request->direccion);
            $familiar->id_cpostal     = $request->id_cpostal;
            $familiar->incapacidad    = $request->incapacidad;
            $familiar->telefono       = $request->telefono;
            $familiar->vinculo        = $request->vinculo;
            $familiar->fec_nacimiento = $request->fec_nacimiento;
            $familiar->fec_alta       = $request->fec_alta;
            $familiar->cod_opr        = Auth::user()->id;
            $familiar->obs            = strtoupper($request->obs);

            $familiar->save();

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
     * Display the specified resource.
     *
     * @param  \App\Models\Familiar  $familiar
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $familiar = Familiar::where('id_familiar', $request->id_familiar)
            ->first();
            
        $nombreTitular = $familiar->getTitular()->first()->nom_titular; // busca el titular correspondiente
        $localidades = CPostal::all();

        $tiposDocumento = DB::table('documento_tipos')
            ->get();
        $estadoCivil = EstadoCivil::orderBy('nombre')
            ->get();
        $categoria = DB::table('categorias')
            ->where('id', $familiar->id_categoria)
            ->orderBy('id')
            ->first();
        $vinculos = DB::table('vinculos')
            ->get();

            return view("familiar/show", compact('localidades','nombreTitular', 'familiar', 'vinculos', 'tiposDocumento', 'estadoCivil', 'categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Familiar  $familiar
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $familiar = Familiar::where('id_familiar', $request->id_familiar)
            ->first();
            
        $nombreTitular = $familiar->getTitular()->first()->nom_titular; // busca el titular correspondiente
        $localidades = CPostal::all();

        $tiposDocumento = DB::table('documento_tipos')
            ->get();
        $estadoCivil = EstadoCivil::get();
        $categoria = DB::table('categorias')
            ->get();
        $vinculos = DB::table('vinculos')
            ->get();

        return view("familiar/edit", compact('localidades','nombreTitular', 'familiar', 'vinculos', 'tiposDocumento', 'estadoCivil', 'categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Familiar  $familiar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $familiar                 = Familiar::findOrFail($request->id_familiar);

            $familiar->nro_doc        = $request->nro_doc;
            $familiar->tp_doc         = $request->tp_doc;
            $familiar->cuil           = $request->cuil;
            $familiar->nom_familiar   = strtoupper($request->nom_familiar);
            $familiar->sexo           = $request->sexo;
            $familiar->direccion      = strtoupper($request->direccion);
            $familiar->id_cpostal     = $request->id_cpostal;
            $familiar->incapacidad    = $request->incapacidad;
            $familiar->telefono       = $request->telefono;
            $familiar->vinculo        = $request->vinculo;
            $familiar->fec_nacimiento = $request->fec_nacimiento;
            $familiar->fec_alta       = $request->fec_alta;
            $familiar->cod_opr        = Auth::user()->id;
            $familiar->obs            = strtoupper($request->obs);

            $familiar->update();

            DB::commit();
            return response()->json(['resultados' => "ok"]);
        } catch (\Throwable $th) {
            DB::rollback();
            $error = $th->getMessage();
            return response()->json(['resultados' => "error", 'error' => $error]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Familiar  $familiar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Familiar $familiar)
    {
        //
    }
}
