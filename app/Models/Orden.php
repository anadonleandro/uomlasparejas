<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Este modelo  representa a la 
 * tabla 
 
 */

class Orden  extends Model
{
  /**
   * Indica el nombre de la tabla en la bd a la que hace referencia el modelo
   * 
   * @var string
   */
  protected $table = 'ordenes';

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


  /**
   * Atributos Asignables en masa
   *
   */
  protected $fillable = [
    'id_titular',
    'id_beneficiario',
    'tipo_beneficiario',
    'solicitante',
    'tipo_estudio',
    'diagnostico',
    'derivacion',
    'obs',
    'fecha_estudio',
    'fecha_realizacion',
    'importe_total',
    'importe_bonificacion',
    'motivo_bonificacion',
    'id_opr',
    'estado',
    'id_opr_anulo',
    'obs_anulo',
    'created_at',
    'updated_at'
  ];

  public function getDetalle()
  {
    return $this->hasMany('App\Models\OrdenDetalle', 'id_orden', 'id');
  }

  public function getOperador()
  {
      return $this->belongsTo('App\Models\User', 'id_opr', 'id');
  }

  public function getOperadorAnulo()
  {
      return $this->belongsTo('App\Models\User', 'id_opr_anulo', 'id');
  }

}
