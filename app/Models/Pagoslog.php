<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagoslog extends Model
{
    protected $table = 'pagoslog';

    protected $primaryKey = 'id_pagoslog';
  
    protected $connection = 'mysql';

    protected $fillable = [
        'tipo_cuenta',
        'cod_seccional',
        'cod_empresa',
        'cuit_empresa',
        'fecha_deposito',
        'periodo',
        'cant_afil_titulares',
        'ipte_total_remuneracion',
        'ipte_depositado',
        'nro_acuerdo',
        'nro_cuota',
        'fecha_proceso',
        'nombre_archivo',
        'id_opr',
        'created_at',
        'updated_at'
      ];

}
