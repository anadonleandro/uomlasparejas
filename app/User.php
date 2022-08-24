<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'estado',
        'id_roll',        
        'email', 
        'password',
        'fec_alta',
        'created_at',
        'updated_at',
        'vencimiento',
        'dni',
        'obs'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // utiliza su propia base de datos
    protected $connection = 'mysql'; 

    public function getSesionesIniciadas()
    {
        return $this->hasMany('App\Models\HistorialLogin', 'cod_usr', 'id');
    }

    public function getUltimaSesion()
    {
        // TODAS LAS SESIONES DEL USUARIO
        $sesiones = HistorialLogin::select('fecha_hora_login')
            ->where('cod_usr', Auth::user()->id)
            ->orderBy('id')
            ->get();
        //  cuenta
        $cantSesiones = count($sesiones);

        switch ($cantSesiones) {
            case 0: // primera vez que entra
                return $ultima_sesion = null;
                break;
            case 1: // segunda vez, no tiene sesion previa, muestra la misma
                $ultima_sesion = $sesiones->keys()->last();
                return $ultima_sesion;
                break;

            default: // inicio normal
                $sesionesKey = $sesiones->keys()->last() - 1;
                $ultima_sesion = $sesiones[$sesionesKey];

                return $ultima_sesion;
                break;
        }
    }
}
