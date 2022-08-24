<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Este modelo  representa a la 
 * tabla 
 
 */

class Familiar  extends Model
{
  /**
   * Indica el nombre de la tabla en la bd a la que hace referencia el modelo
   * 
   * @var string
   */
  protected $table = 'familiares';

  /**
   * Indicica el nombre del campo que es clave primaria
   * 
   * @var string
   */
  protected $primaryKey = 'id_familiar';
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

    'nro_doc',
    'tp_doc',
    'nro_afi',
    'nom_titular',
    'sexo',
    'direccion',
    'id_cpostal',
    'ecivil',
    'id_empresa',
    'fec_nacimiento',
    'fec_alta',
    'fec_ingreso',
    'cod_opr',
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
