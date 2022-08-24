<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Este modelo  representa a la 
 * tabla 
 
 */

class Empresa  extends Model
{
  /**
   * Indica el nombre de la tabla en la bd a la que hace referencia el modelo
   * 
   * @var string
   */
  protected $table = 'empresas';

  /**
   * Indicica el nombre del campo que es clave primaria
   * 
   * @var string
   */
  protected $primaryKey = 'id_empresa';
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
    'id_seccional',
    'cod_empresa',
    'cuit',
    'nom_empresa',
	  'id_cpostal',
    'email',
    'telefono',
    'actividad',
    'fecha_inicio_actividad',
    'fecha_alta',
    'created_at',
    'updated_at'
  ];
  
    ////////////////         EDITAR RELACIONES !!!!!!!!!!!!!!!!!!!!!!!!!

    public function getCPostal()
    {
        return $this->belongsTo('App\Models\CPostal', 'id', 'id_cpostal');
    }

    public function getTitulares()
    {
        return $this->hasMany('App\Models\Titular', 'id_empresa', 'id_empresa');
    }

    public function getDeudas()
    {
        return $this->hasMany('App\Models\Deuda', 'id_empresa', 'id_empresa');
    }


}
