<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        try {
            $check_password = null;
            $usuario = DB::table('users')->where('email', $request->email)->first();

            if ($usuario) {
                $check_password = Hash::check($request->password, $usuario->password);
                
            }

            if (!$usuario || !$check_password || $usuario->estado == 2) {
                Session::flash('message', 'CREDENCIALES INCORRECTAS o USUARIO DESHABILITADO');
                return redirect()->back();
            } else {
                $credentials = $request->only('email', 'password');
                $fechaVencimientoPassword =  $usuario->vencimiento;
                if (Auth::attempt($credentials)) {  // camino con credenciales correctas true

                    if ($fechaVencimientoPassword <= Carbon::now()) {
                        Auth::logout(); // forzamos el deslogueo porque sino si volvemos hcia atras
                        // en el historial se puede ingresar al home y a todas las funciones del sistema
                        // vencio la password, redireccionar a vista de resetPassword

                        return view('auth.resetPassword', compact('usuario'));
                    } else {
                        // se loguea
                        return redirect()->intended('home');
                    }
                } else {
                    Session::flash('message', 'CREDENCIALES INCORRECTAS..!!!');  // cuando esta mal la password           
                    return redirect()->back();
                }
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            if ($th->getCode() != 0) {
                // si no ingreso ninguno de los campos codigo y contraseÃ±a
                Session::flash('message', $th->getMessage());  // cuando esta mal la password 
            }
            //return view('auth/login');
        }
    }
}
