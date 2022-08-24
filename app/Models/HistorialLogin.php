<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialLogin extends Model
{
    protected $table = 'historial_login';
    protected $primaryKey = 'id';
    protected $connection = 'mysql'; // 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_usr',
        'fecha_hora_login',
        'fecha_hora_logout',
        'ip',
        'name',
        'email',
        'created_at',
        'updated_at'
    ];
}
