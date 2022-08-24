<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\User;
use App\Models\Oficina;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;

class UsuarioController extends Controller
{  // Cantidad de dias de vigencia de contraseña //
    const DIAS_VENCIMIENTO = 90;
    ////////////////////////////////////////////////

    public function index()
    {
        $usuarios = User::orderBy('name')->get();
        return view("/usuarios/index", compact('usuarios'));
    }

    public function create()
    {
        return view("/usuarios/create");
    }

    public function store(Request $request)
    {//dd($request->all());
        try {
            DB::beginTransaction();

            $usuario = new User;
            $usuario->name = strtoupper($request->get('name'));
            $usuario->roll = $request->get('roll');
            $usuario->estado = $request->get('estado');
            $usuario->email = strtolower($request->get('email') . "@uom.com"); // siempre en minusculas??
            $usuario->dni = $request->get('dni');
            $usuario->obs = strtoupper($request->get('obs'));
            $usuario->fec_alta = Carbon::now()->format('Y-m-d');
            $usuario->password = Hash::make($request->input('dni'));
            ////incrementa el vencimiento de contraseña 90 días
            $usuario->vencimiento = Carbon::now()->addDay(90)->format('Y-m-d');
            $usuario->save();

            DB::commit();
            return Redirect::to('listadoUsuarios');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            return Redirect::to('listadoUsuarios');
        }
    }

    public function edit(Request $request)
    {
        $usuario = User::findOrFail($request->get('id'));
        return view("usuarios/edit", compact('usuario'));
    }

    public function update(Request $request)
    {//dd($request->all());
        try {
            DB::beginTransaction();

            DB::table('users')->where('id',$request->id)->update([
              'name' => strtoupper($request->name),
              'roll' => $request->roll,
              'estado' => $request->estado,
              'email' => strtolower($request->email."@uom.com"),
              'dni' => $request->dni,
              'obs' => $request->obs
            ]);

            DB::commit();
            return Redirect::to('listadoUsuarios');
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th->getMessage());
            return Redirect::to('listadoUsuarios');
        }
    }

    public function updateresetpass(Request $request)
    { // actualiza constraseña vencida
        try {
            $usuario = User::findOrFail($request->input('id'));

            $nueva_password = [
                'password' => $request->input('password'),
            ];

            $reglas = [
                'password' => [
                    'required',
                    'string',
                    'min:6',             // minimo 6 caracteres
                    'max:12',            // maximo 12 caracteres  
                    'regex:/[a-z]/',      // minus
                    'regex:/[A-Z]/',      // mayuscula
                    'regex:/[0-9]/'       // numers
                ],
            ];

            // VALIDAMOS LA NUEVA PASS CON LAS REGLAS
            $validacion_password = Validator::make($nueva_password, $reglas);

            if (!$validacion_password->fails()) {
                // si la contraseña cumple con las reglas
                $fechaActual = Carbon::now();
                $user = User::findOrFail($request->input('id'));
                $user->password = Hash::make($request->input('password'));
                ////incrementa el vencimiento de contraseña 90 di­as
                $user->vencimiento = $fechaActual->addDay(self::DIAS_VENCIMIENTO);
                $user->update();
                // regresa al login para volver a logearse
                return Redirect::to('/login');
            } else {
                // la contraseña no cumple con las reglas
                Session::flash('error_validacion', 'SU CONTRASEÑA NO CUMPLE CON LOS PARAMETROS REQUERIDOS');
                return view('auth/resetPassword', compact('usuario'));
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function cambioPassword()
    {
        $user = Auth::user();
        return view("usuarios/cambioPassword", compact('user'));
    }

    public function updatepass(Request $request)
    { // cuando el usuario cambia su contraseña
        try {
            $check_password = Hash::check($request->password_actual, Auth::user()->password);
            if ($check_password) {
                $nueva_password = [
                    'password' => $request->input('password'),
                ];
                $reglas = [
                    'password' => [
                        'required',
                        'string',
                        'min:6',             // minimo 6 caracteres
                        'max:12',            // maximo 12 caracteres  
                        'regex:/[a-z]/',      // minus
                        'regex:/[A-Z]/',      // mayuscula
                        'regex:/[0-9]/'       // numers
                    ],
                ];
                $validacion_password = Validator::make($nueva_password, $reglas);

                if (!$validacion_password->fails()) {
                    // si la contraseÃƒÂ±a cumple con las reglas
                    $fechaActual = Carbon::now();
                    $user = User::findOrFail($request->input('id'));
                    $user->password = Hash::make($request->input('password'));
                    ////incrementa el vencimiento de contraseÃƒÂ±a 90 dÃƒÂ­as
                    $user->vencimiento = $fechaActual->addDay(self::DIAS_VENCIMIENTO);
                    $user->update();

                    Auth::logout();
                    //return redirect('/login');
                    return Redirect::to('/');
                } else {
                    // la contraseÃƒÂ±a no cumple con las reglas
                    Session::flash('error_validacion', 'SU CONTRASEÑA NO CUMPLE CON LOS PARAMETROS REQUERIDOS');
                    return redirect()->back();
                }
            } else {
                Session::flash('error_password_actual', 'CONTRASEÑA ACTUAL INCORRECTA');
                return redirect()->back();
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function pruebaImpresion()
    {
        $pdf = PDF::loadView('pruebaImpresionpdf');
        return $pdf->stream();
    }

    public function passwordBlanquear(Request $request)
    { // blanqueamos la contraseña con el legajo del usuario
        //dd($request->all());
        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->input('id'));
            $user->password = Hash::make($user->dni);
            $user->update();

            $db = DB::connection('mysql');

            $usuarios = $db->table('users')
                ->orderBy('name')
                ->get();

            DB::commit();
            return view("/usuarios/index", compact('usuarios'));
        } catch (\Throwable $th) {
            DB::rollback();
            Session::flash('msg', $th->getMessage());
        }
    }

    public function usuario(Request $request)
    { // nota de entrega con codigo y password para usuario
        $fechora = Carbon::now();
        $user = User::findOrFail($request->input('id'));
        $pdf = PDF::loadView('notaEntregaUsuariopdf', compact('fechora', 'user'));
        return $pdf->stream();
    }
}
