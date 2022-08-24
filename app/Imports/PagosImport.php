<?php

namespace App\Imports;

use App\Models\Pagoslog;
use Maatwebsite\Excel\Concerns\ToModel; 
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PagosImport implements ToModel, WithHeadingRow
{
    public function __construct()
    {
        $this->data = collect();
    }

    public function model(array $row)
    {
        $model = Pagoslog::firstOrCreate ([ 
            'tipo_cuenta' => $row['tipo_cuenta'], 
            'cod_seccional' => $row['cod_seccional'], 
            'cod_empresa' => $row['cod_empresa'], 
            'cuit_empresa' => $row[' cuit_empresa'], 
            'fecha_deposito' => $row['fecha_deposito'], 
            'periodo' => $row['periodo'],
            'cant_afil_titulares' => $row['cant_afil_titulares'],
            'ipte_total_remuneracion' => $row['ipte_total_remuneracion'],
            'ipte_depositado' => $row['ipte_depositado'],
            'nro_acuerdo' => $row['nro_acuerdo'],
            'nro_cuota' => $row['nro_cuota'],
            'fecha_proceso' => $row['fecha_proceso'],
            'nombre_archivo' => $row['nombre_archivo'],
            'id_opr' => $row['id_opr']
            ]);

        $this->data->push($model);
        return $model;
    }
}
