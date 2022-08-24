<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Este modelo  representa a la 
 * tabla 
 
 */

class OrdenDetalle  extends Model
{
  /**
   * Indica el nombre de la tabla en la bd a la que hace referencia el modelo
   * 
   * @var string
   */
  protected $table = 'ordenes_detalles';

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
    'id_orden',
    'id_pmo',
    'cod_pmo',
    'cantidad',
    'importe',	  
    'created_at',
    'updated_at'
  ];
  
    ////////////////         EDITAR RELACIONES !!!!!!!!!!!!!!!!!!!!!!!!!

    public function getPmo()
    {
        return $this->belongsTo('App\Models\Pmo', 'id_pmo', 'id');
    }

    public function getTitulares()
    {
        return $this->hasMany('App\Models\Titular', 'id_empresa', 'id_empresa');
    }


}
