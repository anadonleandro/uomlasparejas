<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Este modelo  representa a la 
 * tabla 
 
 */

class Deuda  extends Model
{
  /**
   * Indica el nombre de la tabla en la bd a la que hace referencia el modelo
   * 
   * @var string
   */
  protected $table = 'deudas';

  /**
   * Indicica el nombre del campo que es clave primaria
   * 
   * @var string
   */
  protected $primaryKey = 'id_deuda';
  /**
   * Indica el nombre de la conexion a la cual esta asociado este Modelo,
   * el nombre de la conexion esta definido en config/database.php
   * 
   * @var string
   */
  protected $connection = 'mysql';


  /**
   * Atributos Asignables en masa
   *
   */

  protected $fillable = [
    /** NOTAS:
     *  Tener en cuenta que si nro_afi > 0 debe tener una fecha de afiliacion valida.
     */

    'cod_seccional',
    'id_empresa',
    'cod_empresa',
    'tipo_cuenta',
    'fecha_acreditacion',
    'periodo',
    'cant_afil_titulares',
    'ipte_total_remuneracion',
    'ipte_depositado',
    'nro_acuerdo',
    'nro_cuota',
    'fecha_vto',
    'estado',
    'imputacion_manual',
    'id_opr',
    'created_at',
    'updated_at'
  ];

  //////////////// EDITAR RELACIONES !!!!!!!!!!!!!!!!!!!!!!!!!

  public function getEmpresas()
  {
    return $this->hasMany('App\Models\Empresa', 'id_empresa', 'id_titular');
  }

  public function getCPostal()
  {
    return $this->hasMany('App\Models\CPostal', 'id', 'id_cpostal');
  }

  public function getTitular()
  { // ver esto!!!!!!
      return $this->belongsTo('App\Models\Titular', 'id_titular', 'id_titular');
  }
}
