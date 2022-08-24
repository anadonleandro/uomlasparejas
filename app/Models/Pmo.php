<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Este modelo  representa a la 
 * tabla 
 
 */

class Pmo  extends Model
{
  /**
   * Indica el nombre de la tabla en la bd a la que hace referencia el modelo
   * 
   * @var string
   */
  protected $table = 'practicaspmo';

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
    'codigo',
    'denominacion',
    'created_at',
    'updated_at'
  ];

  public function getDetalle()
  {
    return $this->hasMany(OrdenDetalle::class, 'id_orden', 'id');
  }

  public function getFamiliar()
  {
    return $this->hasOne(Familiar::class, 'id_familiar', 'id_beneficiario');
  }
}
