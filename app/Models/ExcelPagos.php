<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcelPagos  extends Model
{
  /**
   * Indica el nombre de la tabla en la bd a la que hace referencia el modelo
   * 
   * @var string
   */
  protected $table = 'excel_pagos';

  /**
   * Indicica el nombre del campo que es clave primaria
   * 
   * @var string
   */
  protected $primaryKey = 'id';
  /**
   * Indica el nombre de la conexion a la cual esta asociado este Modelo,
   * el nombre de la conexion esta definido en config/database.php
   * 
   * @var string
   */
  protected $connection = 'mysql';

  protected $fillable = [
    'nombre_archivo',
    'fecha_proceso',
    'cod_empresa',
    'id_usr',
    'otros', // cambiar o quitar
    'created_at',
    'updated_at'
  ];
}
