<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificacionMail;
use App\Models\ConfiguracionSmtp;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();
        $now = Carbon::now('America/El_Salvador');
        if ($user && Hash::check($request->password, $user->password)) {
            // La contraseña es correcta
            // Aquí puedes poner la lógica adicional que necesites
            $pin = mt_rand(100001, 999999);
            $user->pin = $pin;
            $user->fecha_pin = $now->format('Y-m-d h:i:s');
            $user->update();

            $subject = 'Envio de pin de verificación';
            $content = "¡Estimado Usuario! Por favor, ingrese el pin " . $pin . " para poder ingresar en la plataforma. <br> Duración de pin es de 3 minutos ";
            $recipientEmail = $request->email;

            $configuracionSmtp = ConfiguracionSmtp::first(); // Supongamos que solo hay una configuración en la base de datos
            config([
                'mail.mailers.smtp.host' => $configuracionSmtp->smtp_host,
                'mail.mailers.smtp.port' => $configuracionSmtp->smtp_port,
                'mail.mailers.smtp.username' => $configuracionSmtp->smtp_username,
                'mail.mailers.smtp.password' => $configuracionSmtp->smtp_password,
                'mail.from.address' => $configuracionSmtp->from_address,
                'mail.mailers.smtp.encryption' => $configuracionSmtp->smtp_encryption,
                'mail.from.name' => $configuracionSmtp->smtp_from_name,
            ]);
            // dd($pin);
            Mail::to($recipientEmail)->send(new VerificacionMail($subject, $content));

            return view('auth.verificacion', compact('user','pin'));
        } else {
            // Las credenciales no coinciden
            return redirect()->route('login')->withErrors(['error' => 'Las credenciales no coinciden']);
        }
        /*$this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);*/
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
