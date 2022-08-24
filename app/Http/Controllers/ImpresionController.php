<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use App\Models\Titular;
use App\Models\Familiar;
use Illuminate\Support\Facades\DB;
use QrCode;

class ImpresionController extends Controller
{
    public function ordenImpresion(Request $request)
    {
        //dd($request->all());
        try {
            $orden = Orden::where('id', $request->orden)
                ->first();

            if ($orden->tipo_beneficiario == 0) {
                // beneficiario es titular
                $titular = Titular::where('id_titular', $orden->id_titular)
                    ->first();

                $dniTitular = number_format($titular->nro_doc, 0, ',', '.'); // formato de DNI
                $tipoDocumentoTitular = DB::table('documento_tipos')
                    ->where('id', $titular->tp_doc)
                    ->first();

                if ($titular->fec_nacimiento != '1900-01-01') {
                    $edadTitular = Carbon::parse($titular->fec_nacimiento)->diffInYears(now());
                } else {
                    $edadTitular = "SIN DATOS";
                }
                $esTitular = "TITULAR"; // solo un texto para mostrar
                $esFamiliar = "FAMILIAR"; // solo un texto para mostrar
                $dniFamiliar = "";
                $edadFamiliar = "";
                $familiar = "";
                $tipoDocumentoFamiliar = "";
            } else {
                // beneficiario es familiar
                // busca las dos personas para mostrar en pdf

                $titular = Titular::where('id_titular', $orden->id_titular)
                    ->first();

                $dniTitular = number_format($titular->nro_doc, 0, ',', '.'); // formato de DNI
                $tipoDocumentoTitular = DB::table('documento_tipos')
                    ->where('id', $titular->tp_doc)
                    ->first();

                if ($titular->fec_nacimiento != '1900-01-01') {
                    $edadTitular = Carbon::parse($titular->fec_nacimiento)->diffInYears(now());
                } else {
                    $edadTitular = "SIN DATOS";
                }
                $esTitular = "TITULAR"; // solo un texto para mostrar
                $esFamiliar = "FAMILIAR"; // solo un texto para mostrar

                $familiar = Familiar::where('id_familiar', $orden->id_beneficiario)
                    ->first();
                $dniFamiliar = number_format($familiar->nro_doc, 0, ',', '.'); // formato de DNI
                $tipoDocumentoFamiliar = DB::table('documento_tipos')
                    ->where('id', $familiar->tp_doc)
                    ->first();

                if ($familiar->fec_nacimiento != '1900-01-01') {
                    $edadFamiliar = Carbon::parse($familiar->fec_nacimiento)->diffInYears(now());
                } else {
                    $edadFamiliar = "SIN DATOS";
                }
            }

            /// datos generales de la orden
            $vencimiento = $orden->created_at->addDays(60);
            $tipoEstudio = DB::table('tipos_prestaciones')
                ->where('id', $orden->tipo_estudio)
                ->first();

            $fecha_hora = Carbon::now();
            $usuario = Auth::user();

            if ($orden->tipo_beneficiario == 0) {
                $beneficiario = $titular->nom_titular;
            } else {
                $beneficiario = $familiar->nom_familiar;
            }
                // probar de pasar más información
            $datosQr = "N° Bono: " . $orden->id . " - Beneficiario: " . $beneficiario;
            $qrcode = base64_encode(QrCode::format('svg')->size(150)->errorCorrection('H')->generate($datosQr));

            $pdf = PDF::loadView("pdf.ordenpdf", compact('orden', 'esTitular', 'esFamiliar', 'titular', 'familiar', 'dniTitular', 'dniFamiliar', 'vencimiento', 'tipoDocumentoTitular', 'tipoDocumentoFamiliar', 'edadTitular', 'edadFamiliar', 'tipoEstudio', 'usuario', 'fecha_hora', 'qrcode'));
            return $pdf->stream();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
