<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    public function verificacion_dos_pasos(Request $request)
    {
        $user = User::findOrFail($request->id);
        $hora_actual = Carbon::now('America/El_Salvador')->format('Y-m-d h:i:s');

        // Verificar si el usuario tiene el rol con ID 3 o 4
        $roleIds = [3, 4];
        $hasRole = $user->roles->pluck('id')->intersect($roleIds)->isNotEmpty();

        // Asignar el valor 1 a la variable de sesión llamada "convenio"
        Session::put('convenio', 1);
        if ($hasRole) {
            $municipio = $user->get_municipios($user->id)->first();
            if ($municipio->convenio == 0) {
                Session::put('convenio', 0);
            }
        }

        // Parsear la hora almacenada en la propiedad fecha_pin del usuario
        $hora_pin = Carbon::create($user->fecha_pin);

        // Calcular la diferencia en minutos entre la hora actual y fecha_pin
        $diff = $hora_pin->diffInMinutes($hora_actual);

        // dd($diff, $hora_actual,$hora_pin);
        //  dd($request->pin == $user->pin);
        if ($request->pin == $user->pin) {
            if ($diff <= 3) {
                $user->pin = 0;
                $user->fecha_pin = null;
                $user->update();
                Auth::login($user);
                return redirect('/home');
            } else {
                $user->pin = 0;
                $user->fecha_pin = null;
                $user->update();
                return redirect()->route('login')->withErrors(['error' => 'Su número de pin ha expirado']);
            }
        } else {
            $user->pin = 0;
            $user->fecha_pin = null;
            $user->update();
            return redirect()->route('login')->withErrors(['error' => 'Su número de pin no coincide']);
        }
    }
}
