<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Request;
use App\Models\HistorialLogin;

class LoginSuccessful
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

    /**
     * Handle the event.
     *
     * @param  IlluminateAuthEventsLogin  $event
     * @return void
     */
    public function handle(Login $event)
    { 
        $clientIP = \Request::getClientIp(true);
        $fechaActual = Carbon::now();
        $name = $event->user->name;
        $email = $event->user->email;
        $id = $event->user->id;

        try {

            $history_log = new HistorialLogin;

            $history_log->cod_usr = $id;
            $history_log->fecha_hora_login = $fechaActual;
            $history_log->fecha_hora_logout = null; // hay que hacerlo
            $history_log->ip = $clientIP;
            $history_log->name = $name;
            $history_log->email = $email;

            $history_log->save();

        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
