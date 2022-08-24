<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Este modelo  representa a la 
 * tabla 
 
 */

class Titular  extends Model
{
    /**
     * Indica el nombre de la tabla en la bd a la que hace referencia el modelo
     * 
     * @var string
     */
    protected $table = 'titulares';

    /**
     * Indicica el nombre del campo que es clave primaria
     * 
     * @var string
     */
    protected $primaryKey = 'id_titular';
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
        'cuil',
        'mail',
        'telefono',
        'incapacidad',
        'cbu',
        'direccion',
        'id_cpostal',
        'ecivil',
        'id_empresa',
        'fec_nacimiento',
        'fec_alta',
        'fec_ingreso',
        'cod_opr',
        'obs',
        'created_at',
        'updated_at'
    ];

    public function getEmpresa()
    {
        return $this->belongsTo('App\Models\Empresa', 'id_empresa', 'id_empresa');
    }

    public function getCPostal()
    {
        return $this->belongsTo('App\Models\CPostal', 'id_cpostal', 'id');
    }

    public function getFamiliares()
    {
        return $this->hasMany('App\Models\Familiar', 'id_titular', 'id_titular');
    }
}
