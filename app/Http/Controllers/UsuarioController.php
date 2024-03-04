<?php

namespace App\Http\Controllers;

use App\Models\catalogo\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (auth()->user()->can('read users')) {
            $usuarios = User::get();

            return view('seguridad.user.index', compact('usuarios'));
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }

    public function create()
    {

        if (auth()->user()->can('create users')) {
            $usuarios = User::get();
            return view('seguridad.user.create', compact('usuarios'));
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }


    public function store(Request $request)
    {

        $messages = [
            'name' => 'El nombre es un valor requerido',
            'password.required' => 'la clave es un valor requerido',
            'email' => 'El Correo electronico es un valor requerido',


        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
        ], $messages);


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        alert()->success('se han sido Agragado correctamente');
        return redirect('seguridad/user/' . $user->id . '/edit');
    }



    public function edit($id)
    {

        if (auth()->user()->can('edit users')) {
            $usuarios = User::findOrFail($id);
            $roles = $usuarios->user_rol;

            $rolArray =  $roles->pluck('id')->toArray();

            $rol_no_asignados = Role::whereNotIn('id', $rolArray)->get();

            $departamentos = Departamento::get();



            return view('seguridad.user.edit', compact('usuarios', 'roles', 'rol_no_asignados', 'departamentos'));
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }

    public function update(Request $request, $id)
    {


        $usuarios = User::findOrFail($id);
        $usuarios->name = $request->name;
        $usuarios->email = $request->email;
        if ($request->password != '') {
            $usuarios->password = Hash::make($request->password);
        }
        //$usuarios->status = 1;
        //$usuarios->region_id = $request->region_id;
        $usuarios->update();
        alert()->success('se han sido Actualizado correctamente');
        return back();
    }

    public function  attach_roles(Request $request)
    {
        $user = User::findOrFail($request->model_id);
        $roles = Role::findOrFail($request->rol_id);
        $user->assignRole($roles->name);
        // $roles->user_has_role()->attach($request->model_id);
        alert()->success('se han sido Agregado correctamente');
        return back();
    }

    public function  dettach_roles(Request $request)
    {

        $roles = Role::findOrFail($request->role_id);
        $roles->user_has_role()->detach($request->model_id);
        alert()->error('El registro ha sido eliminado correctamente');
        return back();
    }


    public function attach_distrito(Request $request)
    {
        $usuario = User::findOrFail($request->usuario_id);
        $usuario->distritos()->attach($request->distrito_id);
        alert()->success('El registro ha sido agregado correctamente');
        return back();
    }

    public function dettach_distrito(Request $request)
    {
        $usuario = User::findOrFail($request->usuario_id);
        $usuario->distritos()->detach($request->distrito_id);
        alert()->success('El registro ha sido agregado correctamente');
        return back();
    }



    public function destroy($id)
    {
        //
    }

    public function cambio_pass()
    {
        return view('auth.change_pass');
    }

    public function update_pass(Request $request)
    {
        $request->validate([
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ]);

        $usuario = User::findOrFail(auth()->user()->id);
        $usuario->password =  Hash::make($request->password);
        $usuario->save();
        alert()->success('El registro ha sido actualizado correctamente');
        return back();
    }
}
