<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\ConfiguracionSmtp;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function correo()
    {
        $configuracion = ConfiguracionSmtp::first();
        $configuracion_key = Configuracion::first();
        return view('configuracion.correo', compact('configuracion','configuracion_key'));
    }

    public function correo_update(Request $request)
    {
        $configuracion = ConfiguracionSmtp::findOrFail($request->Id);
        $configuracion->smtp_host = $request->smtp_host;
        $configuracion->smtp_port = $request->smtp_port;
        $configuracion->smtp_username = $request->smtp_username;
        $configuracion->smtp_password = $request->smtp_password;
        $configuracion->from_address = $request->from_address;
        $configuracion->smtp_encryption = $request->smtp_encryption;
        $configuracion->smtp_from_name = $request->smtp_from_name;
        $configuracion->update();

        $configuracion_key = Configuracion::first();
        $configuracion_key->api_key_maps = $request->api_key_maps;
        $configuracion_key->save();

        alert()->success('El registro ha sido modificado correctamente');
        return back();
    }
}
