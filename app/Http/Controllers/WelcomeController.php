<?php

namespace App\Http\Controllers;

use App\Models\catalogo\Biblioteca;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $biblioteca = Biblioteca::where('activo','=','1')->get();
        return view('welcome', compact('biblioteca'));
    }

}
