<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Carbon;
use App\Models\HistorialLogin;
use Illuminate\Support\Facades\DB; 

class LogoutSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(Logout $event)
    {   // conexion a base
         
        $db = DB::connection('mysql');
       
        try { // busca el maximo id de usuario logueado desde el evento
            $log = $db->table('historial_login')
                ->where('cod_usr', $event->user->id)
                ->max('id');
               

            $history_log = HistorialLogin::findOrFail($log);
            $history_log->fecha_hora_logout = Carbon::now();

            $history_log->update();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
