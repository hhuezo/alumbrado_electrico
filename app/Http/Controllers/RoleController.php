<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role as ModelsRole;
use Carbon\Carbon;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->can('read roles')) {
            $roles = Role::get();
            return view('seguridad.role.index', compact('roles'));
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }

    public function create()
    {
        if (auth()->user()->can('create roles')) {
            $roles = Role::get();
            return view('seguridad.role.create', compact('roles'));
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }



    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if (auth()->user()->can('edit roles')) {

            $role = Role::findOrFail($id);
            $permissions = Permission::get();
            $permission_in_role = $role->role_has_permissions;

            return view('seguridad.role.edit', compact('role', 'permissions', 'permission_in_role'));
        } else {
            alert()->error('Usuario No Autorizado');
            return back();
        }
    }

    public function link_permission(Request $request)
    {
        $role = ModelsRole::findOrFail($request->role_id);

        foreach ($request->permission_id as $obj) {
            $permission = Permission::findOrFail($obj);
            $role->givePermissionTo($permission->name);
        }

        alert()->success('El registro ha sido eliminado correctamente');
        return back();
    }

    public function unlink_permission(Request $request)
    {
        $role = ModelsRole::findOrFail($request->role_id);
        $permission = Permission::findOrFail($request->permission_id);
        $role->revokePermissionTo($permission->name);
        alert()->error('El registro ha sido eliminado correctamente');
        return back();
    }


    public function store(Request $request)
    {
        $time = Carbon::now('America/El_Salvador');
        $rol = new role();
        $rol->name = $request->name;
        $rol->guard_name = 'web';
        $rol->created_at = $time->toDateTimeString();
        $rol->updated_at = $time->toDateTimeString();
        $rol->save();
        alert()->success('se han sido Agregado correctamente');
        return back();
    }


    public function update(Request $request, $id)
    {
        $time = Carbon::now('America/El_Salvador');
        $rol = role::findorFail($id);
        $rol->name = $request->name;
        //  $rol->guard_name ='web';
        // $rol->created_at= $time->toDateTimeString();
        $rol->updated_at = $time->toDateTimeString();
        $rol->update();
        alert()->success('se ha sido Actualizado correctamente');
        return back();
    }

    public function destroy($id)
    {
        $rol = Role::findOrFail($id);
        $rol->delete();
        alert()->error('El registro ha sido eliminado correctamente');
        return back();
    }
}
